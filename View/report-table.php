<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/../Authentication/db_connect.php';

// Initialize arrays to store the fetched files and roles
$files = [];
$user_id = $_SESSION['user_id'];

// Fetch data from the file table
$sql_users_files = "SELECT * FROM files where `category_id` = $categoryName and `create_by` = $user_id";
$result_users = $conn->query($sql_users_files);

if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $files[] = $row;
    }
}

// Fetch data from the as_users table
$user_sql = "SELECT name FROM category where id = $categoryName ";
$result_users = $conn->query($user_sql);

while ($row = $result_users->fetch_assoc()) {
    $names = $row['name'];
}


// Fetch allowed extensions from the database
$extensions_sql = "SELECT DISTINCT extension FROM extension";
$result = $conn->query($extensions_sql);

$allowed_extensions = [];
while ($row = $result->fetch_assoc()) {
    $allowed_extensions[] = $row['extension'];
}

// Create the accept attribute for the file input
$accept_attribute = implode(',', array_map(function($ext) {
    return ".$ext";
}, $allowed_extensions));

// Close the database connection
$conn->close();
?>
<div class="grid grid-cols-1 gap-5" x-data="fileTableData()" x-init="init()">
    <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold"><?php echo $names ?> Table</h2>
            <div x-data="modals" @open="fetchAllowedExtensions()">
                <!-- Modal trigger button and content -->
                <div class="flex items-center justify-center">
                    <button type="button"
                        class="btn border text-primary border-transparent rounded-md transition-all duration-300 hover:text-white hover:bg-primary bg-primary/10"
                        @click="toggle">Upload Files</button>
                </div>
                <div class="fixed inset-0 bg-dark/90 dark:bg-white/5 backdrop-blur-sm z-[99999] hidden overflow-y-auto"
                    :class="open && '!block'">
                    <div class="flex items-center justify-center min-h-screen px-4" @click.self="open = false">
                        <div x-show="open" x-transition x-transition.duration.300
                            class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 rounded-lg overflow-hidden my-8 w-full max-w-lg">
                            <div
                                class="flex bg-white dark:bg-dark items-center border-b border-lightgray/10 dark:border-gray/20 justify-between px-5 py-3">
                                <h5 class="font-semibold text-lg">Upload File</h5>
                                <button type="button" class="text-lightgray hover:text-primary" @click="toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path
                                            d="M12.0007 10.5865L16.9504 5.63672L18.3646 7.05093L13.4149 12.0007L18.3646 16.9504L16.9504 18.3646L12.0007 13.4149L7.05093 18.3646L5.63672 16.9504L10.5865 12.0007L5.63672 7.05093L7.05093 5.63672L12.0007 10.5865Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-5 space-y-4">
                                <form x-ref="uploadForm" @submit.prevent="uploadFile" class="space-y-4">
                                    <!-- File Upload -->
                                    <div class="mb-4">
                                        <label for="file" class="block text-gray-700 dark:text-gray-300">Choose
                                            File</label>
                                        <div class="flex">
                                            <div
                                                class="flex items-center justify-center rounded-l border-2 border-primary bg-primary dark:border-lightgray/20 text-white px-3.5">
                                                <span>
                                                    <!-- SVG for upload icon -->
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <!-- File icon -->
                                                        <path
                                                            d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10L14 2Z"
                                                            fill="currentColor" />
                                                        <!-- Upload arrow -->
                                                        <path d="M13 12H11V8H9L12 5L15 8H13V12Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <label for="file"
                                                class="form-input rounded-l-none rounded-r bg-gray-200 dark:bg-gray-800 dark:text-gray-300 flex items-center cursor-pointer">
                                                <span id="fileName">Choose a file...</span>
                                            </label>
                                            <input id="file" type="file" class="hidden" x-ref="file" required
                                                accept="<?= htmlspecialchars($accept_attribute) ?>">
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-4">
                                        <label for="description"
                                            class="block text-gray-700 dark:text-gray-300">Description</label>
                                        <input type="text" id="description" x-ref="description"
                                            class="form-input rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 w-full"
                                            placeholder="Enter file description" required>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="flex justify-end items-center gap-4">
                                        <button type="button"
                                            class="btn border text-danger border-transparent rounded-md transition-all duration-300 hover:text-white hover:bg-danger bg-danger/10"
                                            @click="toggle">Discard</button>
                                        <button type="submit"
                                            class="btn border text-primary border-transparent rounded-md transition-all duration-300 hover:text-white hover:bg-primary bg-primary/10">Upload</button>
                                    </div>
                                </form>
                            </div>

                            <!-- JavaScript -->
                            <script>
                                document.getElementById('file').addEventListener('change', function () {
                                    const fileName = this.files[0] ? this.files[0].name : 'Choose a file...';
                                    document.getElementById('fileName').innerText = fileName;
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center gap-3">
            <div class="flex space-x-2 items-center">
                <p>Show</p>
                <select id="filter" class="form-select !w-20">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div>
                <input id="search" type="text" class="form-input" placeholder="Search...">
            </div>
        </div>
        <div class="overflow-auto">
            <table id="file-table-drop-area" class="min-w-[640px] w-full mt-4 table-hover">
                <thead>
                    <tr class="text-left">
                        <th>
                            <div class="flex items-center justify-between gap-2">
                                <p>ID</p>
                                <div class="flex flex-col">
                                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        class="h-3 w-3 cursor-pointer text-muted fill-current">
                                        <path d="M5 15l7-7 7 7"></path>
                                    </svg>
                                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        class="h-3 w-3 cursor-pointer text-muted fill-current">
                                        <path d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center justify-between gap-2">
                                <p>Title</p>
                                <div class="flex flex-col">
                                    <svg stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        class="h-3 w-3 cursor-pointer text-muted fill-current">
                                        <path d="M5 15l7-7 7 7"></path>
                                    </svg>
                                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        class="h-3 w-3 cursor-pointer text-muted fill-current">
                                        <path d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center justify-between gap-2">
                                <p>Create Date</p>
                                <div class="flex flex-col">
                                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        class="h-3 w-3 cursor-pointer text-muted fill-current">
                                        <path d="M5 15l7-7 7 7"></path>
                                    </svg>
                                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                        viewBox="0 0 24 24" stroke="currentColor"
                                        class="h-3 w-3 cursor-pointer text-muted fill-current">
                                        <path d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center justify-between gap-2">
                                <p>Download</p>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center justify-between gap-2">
                                <p>Delete</p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(file, index) in files" :key="file.id">
                        <tr x-data="{ editing: false, userRole: file.user_role }">
                            <td x-text="index + 1"></td>
                            <td>
                                <span x-text="file.description"></span>
                            </td>
                            <td>
                                <span x-text="file.create_date"></span>
                            </td>
                            <td>
                                <button href="javascript:;" x-on:click="confirmDownload(file.id)">
                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M1.99951 16.0005H17.9995V9.00049H19.9995V17.0005C19.9995 17.5528 19.5518 18.0005 18.9995 18.0005H0.999512C0.447232 18.0005 -0.000488281 17.5528 -0.000488281 17.0005V9.00049H1.99951V16.0005Z"
                                            fill="#267DFF"></path>
                                        <path
                                            d="M10.9995 7.00049H15.9995L9.99951 13.0005L3.99951 7.00049H8.99951V0.000488281H10.9995V7.00049Z"
                                            fill="#267DFF"></path>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="text-danger ms-2" x-on:click="deleteFile(file.id)">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.29166 5.13898C2.29166 4.75545 2.57947 4.44454 2.93451 4.44454L5.15471 4.44417C5.59584 4.43209 5.985 4.12909 6.13511 3.68084C6.13905 3.66906 6.14359 3.65452 6.15987 3.60177L6.25553 3.29169C6.31407 3.10157 6.36508 2.93594 6.43644 2.78789C6.7184 2.20299 7.24005 1.79683 7.84288 1.69285C7.99547 1.66653 8.15706 1.66664 8.34254 1.66677H11.2409C11.4264 1.66664 11.588 1.66653 11.7406 1.69285C12.3434 1.79683 12.8651 2.20299 13.147 2.78789C13.2184 2.93594 13.2694 3.10157 13.3279 3.29169L13.4236 3.60177C13.4399 3.65452 13.4444 3.66906 13.4484 3.68084C13.5985 4.12909 14.0648 4.43246 14.5059 4.44454H16.6488C17.0038 4.44454 17.2917 4.75545 17.2917 5.13898C17.2917 5.5225 17.0038 5.83342 16.6488 5.83342H2.93451C2.57947 5.83342 2.29166 5.5225 2.29166 5.13898Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.3"
                                            d="M9.67232 18.3333H10.3281C12.5843 18.3333 13.7125 18.3333 14.4459 17.6139C15.1794 16.8946 15.2545 15.7146 15.4046 13.3547L15.6208 9.95428C15.7023 8.67382 15.743 8.03358 15.375 7.62788C15.007 7.22217 14.3856 7.22217 13.1429 7.22217H6.85755C5.61477 7.22217 4.99337 7.22217 4.62541 7.62788C4.25744 8.03358 4.29815 8.67382 4.37959 9.95428L4.59584 13.3547C4.74593 15.7146 4.82097 16.8946 5.55446 17.6139C6.28795 18.3333 7.41607 18.3333 9.67232 18.3333Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="files.length === 0">
                        <tr>
                            <td colspan="6" class="text-center text-muted">No files available</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <ul class="inline-flex items-center gap-1">
            <li><button type="button"
                    class="flex justify-center px-2 h-9 items-center rounded transition border border-gray/20 hover:border-gray/60">First</button>
            </li>
            <li><button type="button"
                    class="flex justify-center px-2 h-9 items-center rounded transition border border-gray/20 hover:border-gray/60">Prev</button>
            </li>
            <template>
                <li><button type="button"
                        class="flex justify-center h-9 w-9 items-center rounded transition border border-gray/20 hover:border-gray/60"
                        x-bind:class="{ 'border-primary text-primary': currentPage === item }"><span
                            x-text="item"></span></button></li>
            </template>
            <li><button type="button"
                    class="flex justify-center px-2 h-9 items-center rounded transition border border-gray/20 hover:border-gray/60">Next</button>
            </li>
            <li><button type="button"
                    class="flex justify-center px-2 h-9 items-center rounded transition border border-gray/20 hover:border-gray/60">Last</button>
            </li>
        </ul>
    </div>
</div>

<script>
    function fileTableData() {
        return {
            files: <?php echo json_encode($files); ?>,
            file: null,
            open: false,
            allowedExtensions: [],

            toggle() {
                this.open = !this.open;
            },

            async fetchAllowedExtensions() {
                try {
                    const response = await fetch('Controller/get_allowed_extensions.php');
                    const extensions = await response.json();
                    this.allowedExtensions = extensions.map(ext => `.${ext}`);
                    this.$refs.file.setAttribute('accept', this.allowedExtensions.join(','));
                } catch (error) {
                    console.error('Error fetching allowed extensions:', error);
                }
            },

            deleteFile(id) {
                if (confirm('Are you sure you want to delete the file? This action cannot be undone.')) {
                    fetch("Controller/delete_file.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: id })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("file deleted successfully");
                                this.files = this.files.filter(file => file.id !== id);
                            } else {
                                alert("Error deleting file: " + data.error);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("An unexpected error occurred: " + error.message);
                        });
                }
            },

            async uploadFile() {
                const fileInput = this.$refs.file;
                const descriptionInput = this.$refs.description;

                if (fileInput.files.length === 0) {
                    alert('Please select a file to upload.');
                    return;
                }

                const formData = new FormData();
                formData.append('file', fileInput.files[0]);
                formData.append('description', descriptionInput.value);
                formData.append('category_id', '<?php echo $categoryName; ?>');

                try {
                    const response = await fetch('Controller/upload_file.php', {
                        method: 'POST',
                        body: formData
                    });

                    const resultText = await response.text(); // Get the raw text response
                    let data;
                    try {
                        data = JSON.parse(resultText); // Attempt to parse as JSON
                    } catch (jsonError) {
                        console.error("JSON parse error:", jsonError);
                        alert("An error occurred while processing the server response.");
                        return;
                    }

                    if (response.ok && data.success) {
                        this.files.push(data.file);
                        alert("File uploaded successfully!");
                        this.toggle(); // Close the modal on success
                    } else {
                        alert("File upload failed: " + (data.error || "Unknown error"));
                    }
                } catch (error) {
                    console.error('Error uploading file:', error);
                    alert("An error occurred while uploading the file.");
                }
            },
            handleFileDrop(event) {
                this.preventDefaults(event);
                const droppedFiles = event.dataTransfer.files;

                if (droppedFiles.length > 0) {
                    this.file = droppedFiles[0];
                    this.autoFillAndOpenModal();
                }
            },
            autoFillAndOpenModal() {
                const fileInput = this.$refs.file;
                console.log('File input reference:', fileInput); // Debugging line

                if (fileInput) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(this.file);
                    fileInput.files = dataTransfer.files;

                    // Open the modal
                    this.toggle();
                } else {
                    console.error("File input reference is not available.");
                }
            },
            preventDefaults(event) {
                event.preventDefault();
                event.stopPropagation();
            },

            init() {
                this.$refs.file; // This should resolve correctly

                const dropArea = document.getElementById('file-table-drop-area');
                dropArea.addEventListener('dragenter', this.preventDefaults, false);
                dropArea.addEventListener('dragleave', this.preventDefaults, false);
                dropArea.addEventListener('dragover', this.preventDefaults, false);
                dropArea.addEventListener('drop', this.handleFileDrop.bind(this), false);
            },

            confirmDownload(fileId) {
                if (confirm("Are you sure you want to download this file?")) {
                    fetch('Controller/download_file.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: fileId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                let link = document.createElement('a');
                                link.href = data.file_url;
                                link.download = data.file_name;
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(() => {
                            alert('Error occurred while processing the request.');
                        });
                }
            }
        }
    }

</script>