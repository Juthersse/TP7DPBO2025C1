<h3>Order List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Table</th>
        <th>Status</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($order->getAllOrders() as $o): ?>
    <tr>
        <td><?= $o['id'] ?></td>
        <td><?= $o['customer_name'] ?></td>
        <td><?= $o['table_number'] ?></td>
        <td class="status-<?= $o['status'] ?>"><?= ucfirst($o['status']) ?></td>
        <td><?= $o['order_date'] ?></td>
        <td class="action-links">
            <a href="?page=order_details&id=<?= $o['id'] ?>">Details</a>
            <a href="?page=orders&edit=<?= $o['id'] ?>">Edit</a>
            <a href="?page=orders&delete_order=<?= $o['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            <?php if ($o['status'] == 'pending'): ?>
                <a href="?page=orders&id=<?= $o['id'] ?>&update_status=preparing">Mark Preparing</a>
            <?php elseif ($o['status'] == 'preparing'): ?>
                <a href="?page=orders&id=<?= $o['id'] ?>&update_status=served">Mark Served</a>
            <?php elseif ($o['status'] == 'served'): ?>
                <a href="?page=orders&id=<?= $o['id'] ?>&update_status=paid">Mark Paid</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (isset($_GET['edit'])): ?>
    <?php $editOrder = $order->getOrderById($_GET['edit']); ?>
    <h3>Edit Order</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editOrder['id'] ?>">
        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?= $editOrder['customer_name'] ?>" required>
        <label>Table Number:</label>
        <input type="text" name="table_number" value="<?= $editOrder['table_number'] ?>" required>
        <label>Status:</label>
        <select name="status">
            <option value="pending" <?= $editOrder['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="preparing" <?= $editOrder['status'] == 'preparing' ? 'selected' : '' ?>>Preparing</option>
            <option value="served" <?= $editOrder['status'] == 'served' ? 'selected' : '' ?>>Served</option>
            <option value="paid" <?= $editOrder['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
        </select>
        <button type="submit" name="update_order">Update Order</button>
    </form>
<?php else: ?>
    <h3>Create New Order</h3>
    <form method="POST">
        <label>Customer Name:</label>
        <input type="text" name="customer_name" required>
        <label>Table Number:</label>
        <input type="text" name="table_number" required>
        
        <h4>Select Dishes:</h4>
        <div class="order-items">
            <?php foreach ($dish->getAllDishes() as $d): ?>
            <div class="order-item">
                <input type="checkbox" id="dish_<?= $d['id'] ?>" name="dish_id[]" value="<?= $d['id'] ?>">
                <label for="dish_<?= $d['id'] ?>"><?= $d['name'] ?> ($<?= $d['price'] ?>)</label>
                <input type="number" name="quantity[]" min="1" value="1">
            </div>
            <?php endforeach; ?>
        </div>
        
        <button type="submit" name="add_order">Create Order</button>
    </form>
<?php endif; ?>
