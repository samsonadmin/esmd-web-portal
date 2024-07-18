<?php




header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include 'global-functions.php';
include 'cms_auth.php';

display_login_form();

include "header.php";

$databaseFile = 'upload.db';

try {
    $db = new PDO('sqlite:' . $databaseFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS hotwork_permits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        date_start TEXT NOT NULL,
        date_end TEXT NOT NULL,
        location TEXT NOT NULL,
        file_path TEXT NOT NULL
    )");
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}


$query = $db->query("SELECT id, date_start, date_end, location, file_path FROM hotwork_permits");
$permits = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-2 content">
    <h2>Hot Work Permit Upload System</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date Start</th>
                <th>Date End</th>
                <th>Location</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody id="permitTableBody">
            <?php if (count($permits) > 0): ?>
                <?php foreach ($permits as $permit): 
                        $download_filename = str_replace(" ", "_" , mb_substr( basename($permit['file_path']), 17) );
                        //$download = $download_filename['filename'];
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($permit['id']); ?></td>
                        <td><?php echo htmlspecialchars($permit['date_start']); ?></td>
                        <td><?php echo htmlspecialchars($permit['date_end']); ?></td>
                        <td><?php echo htmlspecialchars($permit['location']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($permit['file_path']); ?>" download="<?= htmlspecialchars($download_filename) ?>"><i class="fas fa-download"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No permits found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Permit</button>

</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Hot Work Permit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="dateStart" class="form-label">Date Start</label>
                        <input type="text" class="form-control" id="dateStart" name="date_start" required>                        
                    </div>
                    <div class="mb-3">
                        <label for="dateEnd" class="form-label">Date End</label>
                        <input type="text" class="form-control" id="dateEnd" name="date_end" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label">File Upload</label>
                        <div class="drop-zone" id="dropZone">
                            <span>Drag & Drop your file here or click to upload</span>
                            <input type="file" class="form-control" id="fileUpload" name="file" accept=".pdf,.doc,.jpg,.png,.gif" hidden required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script>

  
    document.addEventListener('DOMContentLoaded', function () {

        // Initialize Flatpickr
        flatpickr("#dateStart", {
            dateFormat: "Y-m-d" // Ensure the date is displayed in ISO-8601 format
        });

        // Initialize Flatpickr
        flatpickr("#dateEnd", {
            dateFormat: "Y-m-d" // Ensure the date is displayed in ISO-8601 format
        });

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileUpload');

        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                dropZone.querySelector('span').textContent = fileInput.files[0].name;
            }
        });

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                dropZone.querySelector('span').textContent = e.dataTransfer.files[0].name;
            }
        });

        document.getElementById('uploadForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const dateStart = new Date(document.getElementById('dateStart').value);
            const dateEnd = new Date(document.getElementById('dateEnd').value);

            if (dateStart > dateEnd) {
                alert("End date must be the same as or later than the start date.");
                return;
            }

            const formData = new FormData(this);
            const file = formData.get('file');

            if (file.size > 10 * 1024 * 1024) {
                alert("File size must be less than 10MB.");
                return;
            }

            fetch('server/php/permit-upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(response => {
                alert(response);
                document.getElementById('uploadModal').querySelector('.btn-close').click();
                location.reload();
            })
            .catch(error => alert('Error uploading file.'));
        });
    });
</script>
<? include "footer.php"; ?>
