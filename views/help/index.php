<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help Docs - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .help-container {
            max-width: 760px;
            margin: 50px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.13), 0 2px 8px rgba(108, 99, 255, 0.10);
            position: relative;
        }
        .help-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2em;
        }
        .back-dashboard-btn {
            background: #fff;
            color: #1976d2;
            border: 2px solid #1976d2;
            border-radius: 8px;
            padding: 0.6em 1.3em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            margin-left: 1em;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, border 0.2s;
        }
        .back-dashboard-btn:hover {
            background: #1976d2;
            color: #fff;
            border-color: #1976d2;
        }
        .help-title {
            font-size: 2.2em;
            font-weight: 800;
            color: #1a237e;
            letter-spacing: 1px;
        }
        .add-doc-btn {
            background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.7em 1.5em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
            transition: background 0.2s;
            text-decoration: none;
        }
        .add-doc-btn:hover {
            background: linear-gradient(90deg, #0d47a1 60%, #6c63ff 100%);
        }
        .help-featured {
            background: #e3eafc;
            border-left: 6px solid #1976d2;
            border-radius: 12px;
            padding: 1.5em 1.2em 1.2em 1.5em;
            margin-bottom: 2.5em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.06);
        }
        .help-featured-title {
            font-size: 1.3em;
            font-weight: 700;
            color: #1976d2;
            margin-bottom: 0.5em;
        }
        .help-featured-list {
            color: #222;
            font-size: 1.08em;
            margin-bottom: 0.2em;
            padding-left: 1.2em;
        }
        .blog-article {
            background: #f8fafc;
            border-radius: 16px;
            padding: 2em 1.5em 1.5em 1.5em;
            margin-bottom: 2.2em;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.07);
            position: relative;
            transition: box-shadow 0.2s;
        }
        .blog-article:hover {
            box-shadow: 0 6px 24px rgba(25, 118, 210, 0.13);
        }
        .blog-header {
            display: flex;
            align-items: center;
            margin-bottom: 1em;
        }
        .blog-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #1976d2 60%, #6c63ff 100%);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            font-weight: 700;
            margin-right: 1em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
        }
        .blog-title-meta {
            display: flex;
            flex-direction: column;
        }
        .blog-article-title {
            font-size: 1.35em;
            font-weight: 700;
            color: #1976d2;
            margin-bottom: 0.1em;
        }
        .blog-article-meta {
            font-size: 0.99em;
            color: #888;
        }
        .blog-article-content {
            color: #222;
            font-size: 1.13em;
            margin-top: 0.7em;
            line-height: 1.7;
        }
        .empty-msg {
            text-align: center;
            color: #888;
            margin: 2em 0;
        }
    </style>
</head>
<body>
    <div class="help-container">
        <div class="help-header">
            <div class="help-title">Help & Docs</div>
            <a href="index.php?page=help&action=submit" class="add-doc-btn">+ Add Article</a>
        </div>
        <div class="help-featured">
            <div class="help-featured-title">Getting Started with Simple IPAM</div>
            <ul class="help-featured-list">
                <li><b>Account Management:</b> Admins can create user accounts from the User Management page.</li>
                <li><b>Subnets:</b> Add a subnet from the Subnets page using the "Add Subnet" button.</li>
                <li><b>IP Management:</b> Click a subnet to add or edit IPs. Use the "Add IP" or "Edit" buttons.</li>
                <li><b>Support Role:</b> Support users can only edit IPs in subnets.</li>
                <li><b>Viewing:</b> All users can view subnets and IPs.</li>
                <li><b>Need more help?</b> See the articles below or add your own tips!</li>
            </ul>
        </div>
        <?php if (!empty($docs)): ?>
            <?php foreach ($docs as $doc): ?>
                <div class="blog-article">
                    <div class="blog-header">
                        <div class="blog-avatar"><?= strtoupper(substr($doc['author'], 0, 1)) ?></div>
                        <div class="blog-title-meta">
                            <div class="blog-article-title"><?= $doc['title'] ?></div>
                            <div class="blog-article-meta">
                                By <?= htmlspecialchars($doc['author']) ?> &middot; <?= htmlspecialchars($doc['created_at']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="blog-article-content"><?= $doc['content'] ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-msg">No help articles yet. Be the first to add one!</div>
        <?php endif; ?>
    </div>
</body>
</html>
<div style="text-align:center; margin-top:2.5em;">
            <a href="index.php?page=dashboard" style="
                display: inline-block;
                background: linear-gradient(90deg, #1976d2 60%, #6c63ff 100%);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 0.9em 2.2em;
                font-size: 1.15em;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 2px 8px rgba(25, 118, 210, 0.10);
                transition: background 0.2s;
                margin-top: 1em;
            ">Back to Dashboard</a>
        </div>