<!-- 
   file-lister.php | File Lister Script
   Míriam Domínguez Martínez
-->

<?php
 
// This script list all files and folders from a directory

// Set the directory to list
$directory = "./";
 
// Check if the directory exist
if (!is_dir($directory)) {
    echo "Error: Directory not found";
    exit;
}
 
// Get all files and folders from the directory
$items = scandir($directory);
 
// Remove the special directories "." and ".."
$items = array_filter($items, function($item) {
    return $item !== '.' && $item !== '..';
});
 
// Sort the items
sort($items);
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Lister</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
 
        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
 
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
 
        h1 {
            font-size: 20px;
            margin-bottom: 25px;
            color: #333;
            font-weight: 500;
        }
 
        table {
            width: 100%;
            border-collapse: collapse;
        }
 
        th {
            text-align: left;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
 
        td {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #333;
        }
 
        tr:last-child td {
            border-bottom: none;
        }
 
        .name {
            font-weight: 500;
        }
 
        .folder {
            color: #137054;
        }
 
        .type {
            color: #999;
            font-size: 13px;
        }
 
        .size {
            color: #999;
            font-size: 13px;
            text-align: right;
        }
 
        th:nth-child(2),
        th:nth-child(3),
        td:nth-child(2),
        td:nth-child(3) {
            text-align: right;
        }
 
        .info {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Files & Folders</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <?php
                        $itemPath = $directory . $item;
                        
                        if (is_dir($itemPath)) {
                            $type = "Folder";
                            $size = "—";
                            $class = "folder";
                        } elseif (is_file($itemPath)) {
                            $type = "File";
                            $size = formatBytes(filesize($itemPath));
                            $class = "";
                        } else {
                            continue;
                        }
                    ?>
                    <tr>
                        <td class="name <?php echo $class; ?>"><?php echo htmlspecialchars($item); ?></td>
                        <td class="type"><?php echo $type; ?></td>
                        <td class="size"><?php echo $size; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
 
        <div class="info">
            <?php echo count($items); ?> items
        </div>
    </div>
</body>
</html>
 
<?php
 
/**
 * Function to convert bytes into a readable format
 * @param int $bytes: The size in bytes
 * @return string: The size in readable format
 */
function formatBytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, 2) . ' ' . $units[$pow];
}
 
?>