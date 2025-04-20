<?php
require_once 'class/Dish.php';
require_once 'class/Category.php';
require_once 'class/Order.php';

$dish = new Dish();
$category = new Category();
$order = new Order();

// Handle search
$searchResults = null;
$searchKeyword = '';
if (isset($_GET['search']) && !empty($_GET['keyword'])) {
    $searchKeyword = $_GET['keyword'];
    if ($_GET['search_type'] === 'dishes') {
        $searchResults = $dish->searchDishes($searchKeyword);
    } elseif ($_GET['search_type'] === 'orders') {
        $searchResults = $order->searchOrders($searchKeyword);
    }
}

// Handle CRUD operations for dishes
if (isset($_POST['add_dish'])) {
    $dish->createDish($_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id']);
    header("Location: index.php?page=dishes");
    exit;
}

if (isset($_POST['update_dish'])) {
    $dish->updateDish($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id']);
    header("Location: index.php?page=dishes");
    exit;
}

if (isset($_GET['delete_dish'])) {
    $dish->deleteDish($_GET['delete_dish']);
    header("Location: index.php?page=dishes");
    exit;
}

// Handle CRUD operations for categories
if (isset($_POST['add_category'])) {
    $category->createCategory($_POST['name'], $_POST['description']);
    header("Location: index.php?page=categories");
    exit;
}

if (isset($_POST['update_category'])) {
    $category->updateCategory($_POST['id'], $_POST['name'], $_POST['description']);
    header("Location: index.php?page=categories");
    exit;
}

if (isset($_GET['delete_category'])) {
    $category->deleteCategory($_GET['delete_category']);
    header("Location: index.php?page=categories");
    exit;
}

// Handle CRUD operations for orders
if (isset($_POST['add_order'])) {
    $order_id = $order->createOrder($_POST['customer_name'], $_POST['table_number']);
    if (isset($_POST['dish_id']) && isset($_POST['quantity'])) {
        foreach ($_POST['dish_id'] as $key => $dish_id) {
            if (!empty($_POST['quantity'][$key])) {
                $order->addOrderItem($order_id, $dish_id, $_POST['quantity'][$key]);
            }
        }
    }
    header("Location: index.php?page=orders");
    exit;
}

if (isset($_POST['update_order'])) {
    $order->updateOrder($_POST['id'], $_POST['customer_name'], $_POST['table_number'], $_POST['status']);
    header("Location: index.php?page=orders");
    exit;
}

if (isset($_GET['delete_order'])) {
    $order->deleteOrder($_GET['delete_order']);
    header("Location: index.php?page=orders");
    exit;
}

if (isset($_GET['add_item']) && isset($_POST['add_order_item'])) {
    $order->addOrderItem($_GET['add_item'], $_POST['dish_id'], $_POST['quantity']);
    header("Location: index.php?page=order_details&id=" . $_GET['add_item']);
    exit;
}

if (isset($_GET['remove_item'])) {
    $order_id = $_GET['order_id'];
    $order->removeOrderItem($_GET['remove_item']);
    header("Location: index.php?page=order_details&id=" . $order_id);
    exit;
}

if (isset($_GET['update_status'])) {
    $order->updateOrderStatus($_GET['id'], $_GET['status']);
    header("Location: index.php?page=orders");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <h2>Welcome to Restaurant Management System</h2>
        <nav>
            <a href="?page=dishes">Dishes</a> |
            <a href="?page=categories">Categories</a> |
            <a href="?page=orders">Orders</a>
        </nav>

        <!-- Search Form -->
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="keyword" placeholder="Search..." value="<?= htmlspecialchars($searchKeyword) ?>">
                <select name="search_type">
                    <option value="dishes">Dishes</option>
                    <option value="orders">Orders</option>
                </select>
                <button type="submit" name="search">Search</button>
            </form>
        </div>

        <?php if ($searchResults): ?>
            <div class="search-results">
                <h3>Search Results for "<?= htmlspecialchars($searchKeyword) ?>"</h3>
                <?php if ($_GET['search_type'] === 'dishes'): ?>
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                        </tr>
                        <?php foreach ($searchResults as $d): ?>
                        <tr>
                            <td><?= $d['id'] ?></td>
                            <td><?= $d['name'] ?></td>
                            <td><?= $d['description'] ?></td>
                            <td>$<?= $d['price'] ?></td>
                            <td><?= $d['category_name'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <?php elseif ($_GET['search_type'] === 'orders'): ?>
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Table</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        <?php foreach ($searchResults as $o): ?>
                        <tr>
                            <td><?= $o['id'] ?></td>
                            <td><?= $o['customer_name'] ?></td>
                            <td><?= $o['table_number'] ?></td>
                            <td><?= $o['status'] ?></td>
                            <td><?= $o['order_date'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'dishes') include 'view/dishes.php';
            elseif ($page == 'categories') include 'view/categories.php';
            elseif ($page == 'orders') include 'view/orders.php';
            elseif ($page == 'order_details' && isset($_GET['id'])) {
                $orderDetails = $order->getOrderById($_GET['id']);
                $orderItems = $order->getOrderDetails($_GET['id']);
                include 'view/order_details.php';
            }
        }
        ?>
    </main>
    <?php include 'view/footer.php'; ?>
</body>
</html>
