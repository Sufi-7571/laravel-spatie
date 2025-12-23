<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentItem;

class StripePaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.index', compact('payments'));
    }

    public function process(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Get cart items for this user
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        // Build line items array
        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                        'images' => [$item->product->getImageUrl()],
                    ],
                    'unit_amount' => $item->product->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        // Create payment record
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'stripe_session_id' => $session->id,
            'product_name' => $request->product_name ?? 'Cart Items',
            'amount' => $request->amount,
            'currency' => 'usd',
            'status' => 'pending'
        ]);

        // Save payment items
        foreach ($cartItems as $item) {
            PaymentItem::create([
                'payment_id' => $payment->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->product->price * $item->quantity
            ]);
        }

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        if ($request->session_id) {
            $payment = Payment::where('stripe_session_id', $request->session_id)->first();

            if (!$payment) {
                return redirect()->route('payment.cancel')->with('error', 'Invalid payment session.');
            }

            if ($payment->user_id !== auth()->id()) {
                abort(403);
            }

            // Check if already completed to prevent reuse
            if ($payment->status === 'completed') {
                return redirect()->route('payment.show', $payment)->with('info', 'This payment was already completed.');
            }

            if ($payment->status === 'pending') {
                $payment->update(['status' => 'completed']);
                Cart::where('user_id', auth()->id())->delete();
            }

            return view('payment.success', compact('payment'));
        }

        return redirect()->route('payment.index')->with('error', 'Invalid payment session.');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.show', compact('payment'));
    }

    public function retryPayment(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        if ($payment->status !== 'pending') {
            return redirect()->route('payment.index')->with('error', 'This payment cannot be retried.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        // Get payment items
        $paymentItems = $payment->paymentItems;

        if ($paymentItems->count() == 0) {
            return redirect()->route('payment.index')->with('error', 'No items found for this payment.');
        }

        // Build line items array
        $lineItems = [];
        foreach ($paymentItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product_name,
                        'images' => [$item->product->getImageUrl()],
                    ],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        // Update payment with new session ID
        $payment->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }
}
