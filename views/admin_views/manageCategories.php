<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] != 1) {
    header("Location: ../login. php");
    exit();
}

require_once("../../models/categoryModel.php");
$categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - GadgetGrid Admin</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🔌 GadgetGrid</h2>
            <p>Admin Panel</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php">📊 Dashboard</a></li>
            <li><a href="employeeApproval.php">👥 Employee Approval</a></li>
            <li><a href="viewAllUsers.php">📋 All Users</a></li>
            <li><a href="manageCategories.php" class="active">📁 Categories</a></li>
            <li><a href="stockLogs.php">📦 Stock Logs</a></li>
            <li><a href="profile.php">⚙️ Profile</a></li>
            <li><a href="changePassword.php">🔐 Change Password</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Manage Categories</h1>
            <div class="header-user">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
                <a href="../logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        
        <div class="content-box">
            <?php if (isset($_GET["success"])): ?>
                <div class="success-message"><?php echo htmlspecialchars($_GET["success"]); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET["genErr"])): ?>
                <div class="general-error"><?php echo htmlspecialchars($_GET["genErr"]); ?></div>
            <?php endif; ?>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0; border:  none; padding: 0;">Product Categories</h2>
                <a href="addCategory.php" class="btn btn-primary">+ Add New Category</a>
            </div>
            
            <?php if (empty($categories)): ?>
                <p style="color: #666; padding: 20px 0;">No categories found.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><?php echo $cat['categoryId']; ?></td>
                                    <td><?php echo htmlspecialchars($cat['categoryName']); ?></td>
                                    <td><?php echo htmlspecialchars($cat['description'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($cat['created_at'])); ?></td>
                                    <td>
                                        <div class="action-btns">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="editCategory(<?php echo $cat['categoryId']; ?>, '<?php echo htmlspecialchars($cat['categoryName'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($cat['description'] ?? '', ENT_QUOTES); ?>')">Edit</button>
                                            <form action="../../controllers/categoryControl. php" method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="categoryId" value="<?php echo $cat['categoryId']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Edit Modal -->
        <div id="editModal" style="display: none; position: fixed; top: 0; left:  0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
            <div style="background: white; padding: 30px; border-radius: 10px; width: 100%; max-width: 500px;">
                <h3 style="margin-bottom: 20px;">Edit Category</h3>
                <form action="../../controllers/categoryControl.php" method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="categoryId" id="editCategoryId">
                    
                    <div class="form-group">
                        <label for="editCategoryName">Category Name *</label>
                        <input type="text" id="editCategoryName" name="categoryName" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function editCategory(id, name, description) {
            document.getElementById('editCategoryId').value = id;
            document.getElementById('editCategoryName').value = name;
            document. getElementById('editDescription').value = description;
            document.getElementById('editModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</body>
</html>