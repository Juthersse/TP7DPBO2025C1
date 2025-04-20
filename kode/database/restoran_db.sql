USE restoran_db;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE dishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    table_number VARCHAR(20) NOT NULL,
    status ENUM('pending', 'preparing', 'served', 'paid') DEFAULT 'pending',
    order_date DATETIME NOT NULL
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    dish_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (dish_id) REFERENCES dishes(id)
);

-- Insert sample data
INSERT INTO categories (name, description) VALUES
('Appetizers', 'Small dishes served before the main course'),
('Main Course', 'Primary dishes of a meal'),
('Desserts', 'Sweet dishes served after the main course'),
('Beverages', 'Drinks to accompany your meal');

INSERT INTO dishes (name, description, price, category_id) VALUES
('Bruschetta', 'Toasted bread with tomatoes, garlic, and basil', 8.99, 1),
('Mozzarella Sticks', 'Breaded and fried mozzarella cheese', 7.99, 1),
('Grilled Salmon', 'Fresh salmon fillet with lemon butter sauce', 22.99, 2),
('Beef Steak', 'Grilled beef steak with mushroom sauce', 25.99, 2),
('Pasta Carbonara', 'Spaghetti with creamy egg sauce and bacon', 16.99, 2),
('Chocolate Cake', 'Rich chocolate cake with vanilla ice cream', 9.99, 3),
('Tiramisu', 'Classic Italian dessert with coffee and mascarpone', 8.99, 3),
('Iced Tea', 'Refreshing tea served with ice and lemon', 3.99, 4),
('Fresh Orange Juice', 'Freshly squeezed orange juice', 4.99, 4);

INSERT INTO orders (customer_name, table_number, status, order_date) VALUES
('John Smith', 'A1', 'served', NOW() - INTERVAL 2 HOUR),
('Maria Garcia', 'B3', 'pending', NOW());

INSERT INTO order_items (order_id, dish_id, quantity) VALUES
(1, 3, 1),
(1, 6, 2),
(1, 8, 2),
(2, 1, 1),
(2, 5, 1),
(2, 7, 1);
