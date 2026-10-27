<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $staff = User::create([
                'name' => 'John Staff',
                'email' => 'staff@example.com',
                'password' => Hash::make('password123'),
            ]);

            $cat1 = Category::create(['name' => 'Electronics', 'description' => 'Gadgets and devices']);
            $cat2 = Category::create(['name' => 'Books', 'description' => 'Textbooks and novels']);
            $cat3 = Category::create(['name' => 'Clothing', 'description' => 'Apparel and wear']);

            $p1 = Product::create(['category_id' => $cat1->id, 'name' => 'Laptop', 'price' => 1000.00, 'stock_quantity' => 10, 'is_available' => true]);
            $p2 = Product::create(['category_id' => $cat1->id, 'name' => 'Mouse', 'price' => 25.00, 'stock_quantity' => 50, 'is_available' => true]);
            $p3 = Product::create(['category_id' => $cat2->id, 'name' => 'Laravel Book', 'price' => 45.00, 'stock_quantity' => 20, 'is_available' => true]);
            $p4 = Product::create(['category_id' => $cat2->id, 'name' => 'PHP Guide', 'price' => 35.00, 'stock_quantity' => 15, 'is_available' => true]);
            $p5 = Product::create(['category_id' => $cat3->id, 'name' => 'T-Shirt', 'price' => 20.00, 'stock_quantity' => 100, 'is_available' => true]);
            $p6 = Product::create(['category_id' => $cat3->id, 'name' => 'Jacket', 'price' => 80.00, 'stock_quantity' => 30, 'is_available' => true]);

            $c1 = Customer::create(['name' => 'Alice Smith', 'email' => 'alice@example.com', 'phone' => '1234567890']);
            $c2 = Customer::create(['name' => 'Bob Johnson', 'email' => 'bob@example.com', 'phone' => '0987654321']);
            $c3 = Customer::create(['name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'phone' => '1122334455']);

            $ordersData = [
                ['customer' => $c1, 'ref' => 'ORD-001', 'items' => [[$p1, 1], [$p2, 2]]],
                ['customer' => $c2, 'ref' => 'ORD-002', 'items' => [[$p3, 2], [$p4, 1]]],
                ['customer' => $c3, 'ref' => 'ORD-003', 'items' => [[$p5, 3], [$p6, 1]]],
            ];

            $createdOrders = [];

            foreach ($ordersData as $oData) {
                $total = 0;
                $itemsToInsert = [];

                foreach ($oData['items'] as $itemData) {
                    $product = $itemData[0];
                    $qty = $itemData[1];
                    $unitPrice = $product->price;
                    $subtotal = $unitPrice * $qty;
                    $total += $subtotal;

                    $itemsToInsert[] = [
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'subtotal' => $subtotal,
                    ];
                }

                $order = Order::create([
                    'order_number' => $oData['ref'],
                    'customer_id' => $oData['customer']->id,
                    'user_id' => $staff->id,
                    'order_date' => now(),
                    'status' => 'completed',
                    'total_amount' => $total,
                ]);

                foreach ($itemsToInsert as $item) {
                    $order->items()->create($item);
                }

                $createdOrders[] = $order;
            }

            Payment::create([
                'order_id' => $createdOrders[0]->id,
                'payment_reference' => 'PAY-1001',
                'payment_method' => 'Credit Card',
                'amount' => $createdOrders[0]->total_amount,
                'paid_at' => now(),
            ]);

            Payment::create([
                'order_id' => $createdOrders[1]->id,
                'payment_reference' => 'PAY-1002',
                'payment_method' => 'Cash',
                'amount' => $createdOrders[1]->total_amount,
                'paid_at' => now(),
            ]);
        });
    }
}