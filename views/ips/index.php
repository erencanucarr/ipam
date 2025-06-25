<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IP Addresses - <?= htmlspecialchars($subnet['name']) ?> - Simple IPAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            padding: 2.5em 2em 2em 2em;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1.5px 4px rgba(0,0,0,0.08);
        }
        h1 {
            text-align: center;
            color: #1a237e;
            margin-bottom: 1.5em;
            letter-spacing: 1px;
        }
        .top-bar {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-bottom: 1em;
        }
        .top-bar .button-row {
            display: flex;
            gap: 1em;
        }
        .top-bar a {
            background: #1976d2;
            color: #fff;
            width: 120px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.08em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
            transition: background 0.2s;
            margin: 0;
        }
        .top-bar a:hover {
            background: #0d47a1;
        }
        .button-row {
            gap: 16px;
        }
        .ip-range {
            font-weight: bold;
            margin-bottom: 1em;
            color: #1976d2;
            font-size: 1.1em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #f8fafc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .ip-row-assigned {
            background: #ffeaea !important;
        }
        .ip-row-free {
            background: #eaffea !important;
        }
        .ip-row-reserved {
            background: #f4f4f4 !important;
        }
        th, td {
            padding: 1em 0.7em;
            text-align: left;
        }
        th {
            background: #e3eafc;
            color: #1a237e;
            font-size: 1.05em;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        /* Clean, modern table row separation */
        tr.ip-row-assigned,
        tr.ip-row-free,
        tr.ip-row-reserved {
            border-bottom: 2px solid #e0e0e0;
        }
        th, td {
            border-right: none;
        }
        tr:nth-child(even) {
            background: #f0f4f8;
        }
        tr:hover {
            background: #e3eafc;
            transition: background 0.2s;
        }
        .ip-status-icon {
            font-size: 1.3em;
            margin-right: 0.5em;
            vertical-align: middle;
        }
        .actions a {
            margin-right: 0.7em;
            color: #1976d2;
            text-decoration: none !important;
            font-weight: bold !important;
            border-bottom: none !important;
            transition: color 0.2s;
        }
        .actions a:hover {
            color: #0d47a1;
        }
        .ip-action-link {
            color: #1976d2;
            text-decoration: none !important;
            font-weight: bold !important;
            border-bottom: none !important;
            transition: color 0.2s;
        }
        .ip-action-link:hover {
            color: #0d47a1;
        }
        .back-link, .back-link-top {
            display: block;
            margin-top: 1em;
            text-align: left;
            color: #6c63ff;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            transition: color 0.2s;
            width: fit-content;
        }
        .back-link:hover, .back-link-top:hover {
            color: #1a237e;
        }
        .back-link {
            margin: 2em auto 0 auto;
            text-align: center;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0; width: 100vw; height: 100vh;
            background: rgba(30,40,60,0.25);
            justify-content: center;
            align-items: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18), 0 2px 8px rgba(108, 99, 255, 0.10);
            padding: 2.7em 2.7em 2.7em 2.7em;
            min-width: 520px;
            max-width: 98vw;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal .section-title {
            background: #1976d2;
            color: #fff;
            padding: 1.1em 1.2em;
            font-weight: 700;
            border-radius: 8px 8px 0 0;
            font-size: 1.15em;
            letter-spacing: 1px;
            margin-bottom: 1.5em;
        }
        .modal-table, .modal-history-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2.5em;
        }
        .modal-table th, .modal-table td,
        .modal-history-table th, .modal-history-table td {
            border: 1px solid #b0bec5;
            padding: 0.7em 1em;
            font-size: 1em;
        }
        .modal-table th {
            background: #e3eafc;
            color: #1a237e;
            width: 180px;
            text-align: left;
        }
        .modal-table td {
            background: #f8fafc;
        }
        .modal-history-table th {
            background: #1976d2;
            color: #fff;
            font-weight: 600;
            text-align: left;
        }
        .modal-history-table td {
            background: #f8fafc;
        }
        .modal-actions {
            margin-top: 2.2em;
            margin-bottom: 2.2em;
            display: flex;
            gap: 2.5em;
        }
        .modal-actions a {
            background: #1976d2;
            color: #fff;
            padding: 0.7em 1.5em;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1em;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
            transition: background 0.2s;
        }
        .modal-actions a:hover {
            background: #0d47a1;
        }
        .modal-close {
            position: absolute;
            top: 18px;
            right: 24px;
            font-size: 1.5em;
            color: #1976d2;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <div class="button-row">
                <a href="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>&action=create">Add IP</a>
                <a class="back-link-top" href="index.php?page=subnets">Back</a>
            </div>
        </div>
        <h1>IP Addresses for <?= htmlspecialchars($subnet['name']) ?> (<?= htmlspecialchars($subnet['network']) ?>/<?= htmlspecialchars($subnet['cidr']) ?>)</h1>
        <div class="ip-range">IP RANGE <?= htmlspecialchars($subnet['network']) ?></div>
        <table>
            <thead>
                <tr>
                    <th>Details</th>
                    <th>Edit</th>
                    <th>IP</th>
                    <th>MASK</th>
                    <th>DESCRIPTION</th>
                    <th>CLIENT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Prepare JS data for all IPs and their history
                $ip_js_data = [];
                foreach ($ips as $ip) {
                    $ip_id = $ip['id'];
                    // Fetch history for this IP (assume $ip_histories[$ip_id] is available, else empty array)
                    $history = isset($ip_histories[$ip_id]) ? $ip_histories[$ip_id] : [];
                    $ip_js_data[$ip_id] = [
                        'id' => $ip_id,
                        'address' => $ip['address'],
                        'mask' => $ip['mask'],
                        'description' => $ip['description'],
                        'client' => $ip['client'],
                        'history' => $history
                    ];
                }
                ?>
                <?php if (empty($ips)): ?>
                    <tr><td colspan="6">No IP addresses found.</td></tr>
                <?php else: foreach ($ips as $ip): ?>
                    <tr class="ip-row-<?= strtolower(htmlspecialchars($ip['status'])) ?>">
                        <td><a href="#" class="details-link ip-action-link" data-ipid="<?= $ip['id'] ?>">Details</a></td>
                        <td><a href="index.php?page=ips&subnet_id=<?= $subnet['id'] ?>&action=edit&id=<?= $ip['id'] ?>" class="ip-action-link">Edit</a></td>
                        <td>
                            <?php
                                if ($ip['status'] === 'assigned') {
                                    echo '<span class="ip-status-icon" title="Assigned">❌</span>';
                                } elseif ($ip['status'] === 'free') {
                                    echo '<span class="ip-status-icon" title="Free">✅</span>';
                                } elseif ($ip['status'] === 'reserved') {
                                    echo '<span class="ip-status-icon" title="Reserved">❓</span>';
                                }
                            ?>
                            <?= htmlspecialchars($ip['address']) ?>
                        </td>
                        <td><?= htmlspecialchars($ip['mask']) ?></td>
                        <td><?= htmlspecialchars($ip['description']) ?></td>
                        <td><?= htmlspecialchars($ip['client']) ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
        <a class="back-link" href="index.php?page=subnets">Back</a>
    </div>
    <!-- Modal for IP Details -->
    <div class="modal" id="ipDetailsModal">
        <div class="modal-content">
            <span class="modal-close" id="modalCloseBtn">&times;</span>
            <div class="section-title">ADDRESS MANAGEMENT</div>
            <table class="modal-table" id="modalDetailsTable">
                <tr>
                    <th>IP</th>
                    <td id="modal-ip"></td>
                </tr>
                <tr>
                    <th>MASK</th>
                    <td id="modal-mask"></td>
                </tr>
                <tr>
                    <th>DESCRIPTION</th>
                    <td id="modal-description"></td>
                </tr>
                <tr>
                    <th>CLIENT</th>
                    <td id="modal-client"></td>
                </tr>
            </table>
            <div class="modal-actions">
                <a href="#" id="modalGoBack">GO BACK</a>
                <a href="#" id="modalEdit">EDIT</a>
            </div>
            <div class="section-title" style="margin-top:2em;">UPDATE HISTORY</div>
            <table class="modal-history-table" id="modalHistoryTable">
                <thead>
                    <tr>
                        <th>USERNAME</th>
                        <th>MODIFICATION TIME/DATE</th>
                        <th>HOST ADDRESS</th>
                    </tr>
                </thead>
                <tbody id="modal-history-body">
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Embed all IP data for modal use
        const ipData = <?= json_encode($ip_js_data) ?>;
        const subnetId = <?= json_encode($subnet['id']) ?>;
        document.querySelectorAll('.details-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const ipid = this.getAttribute('data-ipid');
                const data = ipData[ipid];
                if (!data) return;
                document.getElementById('modal-ip').textContent = data.address;
                document.getElementById('modal-mask').textContent = data.mask;
                document.getElementById('modal-description').textContent = data.description;
                document.getElementById('modal-client').textContent = data.client;
                // Fill history
                const tbody = document.getElementById('modal-history-body');
                tbody.innerHTML = '';
                if (data.history && data.history.length > 0) {
                    data.history.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td>${row.user_name}</td><td>${row.created_at}</td><td>${row.device_ip}</td>`;
                        tbody.appendChild(tr);
                    });
                } else {
                    const tr = document.createElement('tr');
                    tr.innerHTML = '<td colspan="3">No update history found.</td>';
                    tbody.appendChild(tr);
                }
                // Set edit/go back links
                document.getElementById('modalEdit').setAttribute('href', `index.php?page=ips&subnet_id=${subnetId}&action=edit&id=${ipid}`);
                document.getElementById('modalGoBack').onclick = function(ev) {
                    ev.preventDefault();
                    document.getElementById('ipDetailsModal').classList.remove('active');
                };
                document.getElementById('ipDetailsModal').classList.add('active');
            });
        });
        document.getElementById('modalCloseBtn').onclick = function() {
            document.getElementById('ipDetailsModal').classList.remove('active');
        };
        // Close modal on outside click
        document.getElementById('ipDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });
    </script>
</body>
</html>