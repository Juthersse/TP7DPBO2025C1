<h3>Dish List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($dish->getAllDishes() as $d): ?>
    <tr>
        <td><?= $d['id'] ?></td>
        <td><?= $d['name'] ?></td>
        <td><?= $d['description'] ?></td>
        <td>$<?= $d['price'] ?></td>
        <td><?= $d['category_name'] ?></td>
        <td class="action-links">
            <a href="?page=dishes&edit=<?= $d['id'] ?>">Edit</a>
            <a href="?page=dishes&delete_dish=<?= $d['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (isset($_GET['edit'])): ?>
    <?php $editDish = $dish->getDishById($_GET['edit']); ?>
    <h3>Edit Dish</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editDish['id'] ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $editDish['name'] ?>" required>
        <label>Description:</label>
        <textarea name="description"><?= $editDish['description'] ?></textarea>
        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?= $editDish['price'] ?>" required>
        <label>Category:</label>
        <select name="category_id">
            <?php foreach ($category->getAllCategories() as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $editDish['category_id'] ? 'selected' : '' ?>>
                    <?= $c['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="update_dish">Update Dish</button>
    </form>
<?php else: ?>
    <h3>Add New Dish</h3>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Description:</label>
        <textarea name="description"></textarea>
        <label>Price:</label>
        <input type="number" name="price" step="0.01" required>
        <label>Category:</label>
        <select name="category_id">
            <?php foreach ($category->getAllCategories() as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="add_dish">Add Dish</button>
    </form>
<?php endif; ?>
