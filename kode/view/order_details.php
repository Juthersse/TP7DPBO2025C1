<h3>Order Details</h3>
<div class="order-info">
    <p><strong>Order ID:</strong> <?= $orderDetails['id'] ?></p>
    <p><strong>Customer:</strong> <?= $orderDetails['customer_name'] ?></p>
    <p><strong>Table:</strong> <?= $orderDetails['table_number'] ?></p>
    <p><strong>Status:</strong> <span class="status-<?= $orderDetails['status'] ?>"><?= ucfirst($orderDetails['status']) ?></span></p>
    <p><strong>Date:</strong> <?= $orderDetails['order_date'] ?></p>
</div>

<h4>Order Items</h4>
<table border="1">
    <tr>
        <th>Dish</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Actions</th>
    </tr>
    <?php 
    $total = 0;
    foreach ($orderItems as $item): 
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <tr>
        <td><?= $item['dish_name'] ?></td>
        <td>$<?= $item['price'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td>$<?= number_format($subtotal, 2) ?></td>
        <td>
            <a href="?page=order_details&order_id=<?= $orderDetails['id'] ?>&remove_item=<?= $item['id'] ?>" onclick="return confirm('Are you sure?')">Remove</a>
        </td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" align="right"><strong>Total:</strong></td>
        <td><strong>$<?= number_format($total, 2) ?></strong></td>
        <td></td>
    </tr>
</table>

<h4>Add Item to Order</h4>
<form method="POST" action="?page=order_details&add_item=<?= $orderDetails['id'] ?>">
    <label>Dish:</label>
    <select name="dish_id">
        <?php foreach ($dish->getAllDishes() as $d): ?>
            <option value="<?= $d['id'] ?>"><?= $d['name'] ?> ($<?= $d['price'] ?>)</option>
        <?php endforeach; ?>
    </select>
    <label>Quantity:</label>
    <input type="number" name="quantity" min="1" value="1">
    <button type="submit" name="add_order_item">Add Item</button>
</form>

<p><a href="?page=orders">Back to Orders</a></p>
