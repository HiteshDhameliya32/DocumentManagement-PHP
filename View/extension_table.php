<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/../Authentication/db_connect.php';

// Retrieve user ID from session
if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'User not logged in';
    echo json_encode($response);
    exit;
}
$create_by = $_SESSION['user_id'];

$sql_user = "SELECT `username` FROM `as_users` WHERE `user_id` = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $create_by);
$stmt->execute();
$result_user = $stmt->get_result();

if ($result_user->num_rows > 0) {
    while ($row = $result_user->fetch_assoc()) {
        $user_name = $row['username'];
    }
}


// Initialize arrays to store the fetched extension
$extensions = [];

// Fetch data from the extension and as_user tables
$sql_category = "
    SELECT 
        e.`id`, 
        e.`extension`, 
        e.`create_date`, 
        e.`create_by`, 
        u.`username`
    FROM 
        `extension` e
    JOIN 
        `as_users` u ON e.`create_by` = u.`user_id`
";
$result_category = $conn->query($sql_category);

if ($result_category->num_rows > 0) {
    while ($row = $result_category->fetch_assoc()) {
        $extensions[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<div class="grid grid-cols-1 gap-5" x-data="categoryTableData()">
    <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-base font-semibold">extension Table</h2>
            <div x-data="modals">
                <div class="flex items-center justify-center">
                    <button type="button"
                        class="btn border text-primary border-transparent rounded-md transition-all duration-300 hover:text-white hover:bg-primary bg-primary/10"
                        @click="toggle">Add extension</button>
                </div>
                <div class="fixed inset-0 bg-dark/90 dark:bg-white/5 backdrop-blur-sm z-[99999] hidden overflow-y-auto"
                    :class="open && '!block'">
                    <div class="flex items-center justify-center min-h-screen px-4" @click.self="open = false">
                        <div x-show="open" x-transition x-transition.duration.300
                            class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 rounded-lg overflow-hidden my-8 w-full max-w-lg">
                            <div
                                class="flex bg-white dark:bg-dark items-center border-b border-lightgray/10 dark:border-gray/20 justify-between px-5 py-3">
                                <h5 class="font-semibold text-lg">Add extension</h5>
                                <button type="button" class="text-lightgray hover:text-primary" @click="toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path
                                            d="M12.0007 10.5865L16.9504 5.63672L18.3646 7.05093L13.4149 12.0007L18.3646 16.9504L16.9504 18.3646L12.0007 13.4149L7.05093 18.3646L5.63672 16.9504L10.5865 12.0007L5.63672 7.05093L7.05093 5.63672L12.0007 10.5865Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-5 space-y-4">
                                <form class="space-y-4">
                                    <input id="extension-name" type="text"
                                        class="form-input rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 w-full"
                                        placeholder="Type extension" required>
                                    <script>
                                        document.getElementById('extension-name').addEventListener('input', function () {
                                            this.value = this.value.toLowerCase();
                                        });
                                    </script>
                                </form>
                                <div class="flex justify-end items-center gap-4">
                                    <button type="button"
                                        class="btn border text-danger border-transparent rounded-md transition-all duration-300 hover:text-white hover:bg-danger bg-danger/10"
                                        @click="toggle">Discard</button>
                                    <button type="button"
                                        class="btn border text-primary border-transparent rounded-md transition-all duration-300 hover:text-white hover:bg-primary bg-primary/10"
                                        @click="addExtension">ADD</button>

                                </div>
                            </div>
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
            <table class="min-w-[640px] w-full product-table">
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
                                <p>Extension</p>
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
                                <p>created date</p>
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
                                <p>Created By</p>
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
                                <p>Action</p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(extension, index) in extensions" :key="extension.id">
                        <tr x-data="{ editing: false}">
                            <td x-text="index + 1"></td>
                            <td>
                                <span x-text="extension.extension"></span>
                            </td>
                            <td>
                                <span x-text="extension.create_date"></span>
                            </td>
                            <td>
                                <span
                                    x-text="extension.username ? extension.username : '<?php echo $user_name ?>'"></span>
                            </td>
                            <td>
                                <button class="text-danger ms-2" x-on:click="deleteExtension(extension.id)">
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
    function categoryTableData() {
        return {
            extensions: <?php echo json_encode($extensions); ?>, // Initialize as an array

            deleteExtension(id) {
                console.log('Category type before deletion:', Array.isArray(this.categorys) ? 'Array' : 'Not an array');
                console.log('Category value before deletion:', this.categorys);
                // Alert to confirm the deletion of the extension
                if (confirm('Are you sure you want to delete the extension?')) {
                    fetch("Controller/delete_extension.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: id })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            alert("Extension deleted successfully");
                            this.extensions = this.extensions.filter(ex => ex.id !== id);
                        } else {
                            console.error("Error deleting extension:", data.error);
                        }
                    })
                        .catch(error => console.error("Error:", error));
                } else {
                    console.log("Extension deletion canceled");
                }
            },

            addExtension() {
                const extension = document.querySelector('#extension-name').value.trim();
                const create_date = new Date().toISOString().slice(0, 19).replace('T', ' ');

                if (!extension) {
                    console.error('Extension name is required.');
                    return;
                }

                fetch("Controller/add_extension.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        extension: extension,
                        create_date: create_date,
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();  // Parse JSON directly instead of text
                    })
                    .then(data => {
                        if (data.success) {
                            alert("Extension added successfully");
                            this.extensions.push(data.extension);  // Using correct key from the PHP response
                            document.querySelector('#extension-name').value = '';
                            this.open = false;
                        } else {
                            console.error("Error adding extension:", data.error);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            },
            fetchUsername(userId) {
                if (userId) {
                    fetch('Controller/get_username.php?user_id=' + userId)
                        .then(response => response.text())  // Change to .text() to see the full response
                        .then(data => {
                            console.log('Response:', data);  // Log the response to check its content
                            this.username = JSON.parse(data).username ? JSON.parse(data).username : 'Unknown User';
                        })
                        .catch(error => {
                            console.error('Error fetching username:', error);
                        });
                }
            }
        }
    }
</script>