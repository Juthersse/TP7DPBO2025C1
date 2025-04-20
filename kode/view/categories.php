<h3>Category List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($category->getAllCategories() as $c): ?>
    <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['name'] ?></td>
        <td><?= $c['description'] ?></td>
        <td class="action-links">
            <a href="?page=categories&edit=<?= $c['id'] ?>">Edit</a>
            <a href="?page=categories&delete_category=<?= $c['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (isset($_GET['edit'])): ?>
    <?php $editCategory = $category->getCategoryById($_GET['edit']); ?>
    <h3>Edit Category</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $editCategory['name'] ?>" required>
        <label>Description:</label>
        <textarea name="description"><?= $editCategory['description'] ?></textarea>
        <button type="submit" name="update_category">Update Category</button>
    </form>
<?php else: ?>
    <h3>Add New Category</h3>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Description:</label>
        <textarea name="description"></textarea>
        <button type="submit" name="add_category">Add Category</button>
    </form>
<?php endif; ?>
