<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/../Authentication/db_connect.php';

// Initialize arrays to store the fetched users and roles
$users = [];
$roles = [];

// Fetch data from the as_users table
$sql_users = "SELECT user_id, email, username, user_role FROM as_users";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch data from the as_user_roles table
$sql_roles = "SELECT role_id, role FROM as_user_roles";
$result_roles = $conn->query($sql_roles);

if ($result_roles->num_rows > 0) {
    while ($row = $result_roles->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<div class="grid grid-cols-1 gap-5">
    <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
        <h2 class="text-base font-semibold mb-4">User Table</h2>
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
        <div class="overflow-auto" x-data="userTableData()">
            <table class="min-w-[640px] w-full mt-4 table-hover">
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
                                <p>Email</p>
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
                                <p>Username</p>
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
                                <p>Role</p>
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
                    <template x-for="(user, index) in users" :key="user.user_id">
                        <tr x-data="{ editing: false, userRole: user.user_role }">
                            <td x-text="index + 1"></td>
                            <td>
                                <span x-show="!editing" x-text="user.email"
                                    x-on:dblclick="editing = true; $nextTick(() => $refs.email.focus())"></span>
                                <input x-show="editing" x-ref="email" type="text" class="form-input"
                                    x-model="user.email"
                                    x-on:keydown.enter="editing = false; updateUser(user.user_id, user.email, user.username, userRole)">
                            </td>
                            <td>
                                <span x-show="!editing" x-text="user.username"
                                    x-on:dblclick="editing = true; $nextTick(() => $refs.username.focus())"></span>
                                <input x-show="editing" x-ref="username" type="text" class="form-input"
                                    x-model="user.username"
                                    x-on:keydown.enter="editing = false; updateUser(user.user_id, user.email, user.username, userRole)">
                            </td>
                            <td>
                                <span x-show="!editing"
                                    x-text="roles.find(role => role.role_id == userRole)?.role || 'Unknown Role'"
                                    x-on:dblclick="editing = true"></span>
                                <select class="form-select" x-show="editing" x-model="userRole"
                                    x-init="userRole = userRole || user.originalRoleId"
                                    x-on:keydown.enter="editing = false; updateUser(user.user_id, user.email, user.username, userRole)">
                                    <template x-for="role in roles" :key="role.role_id">
                                        <option :value="role.role_id" x-text="role.role"></option>
                                    </template>
                                </select>
                            </td>

                            <td>
                                <button class="text-danger ms-2" x-on:click="deleteUser(user.user_id)">
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
    function userTableData() {
        return {
            users: <?php echo json_encode($users); ?>,
            roles: <?php echo json_encode($roles); ?>,
            deleteUser(userId) {
                console.log('Category type before deletion:', Array.isArray(this.users) ? 'Array' : 'Not an array');
                console.log('Category value before deletion:', this.users);
                // Alert to confirm the deletion of the user
                if (confirm('Are you sure you want to delete the user?')) {
                    fetch("Controller/delete_user.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ user_id: userId })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            alert("User deleted successfully");
                            this.users = this.users.filter(user => user.user_id !== userId);
                        } else {
                            console.error("Error deleting user:", data.error);
                        }
                    }).catch(error => console.error("Error:", error));
                } else {
                    console.log("User deletion canceled");
                }
            },
            updateUser(userId, email, username, userRole) {
                //this is to conform that you want to update the data
                if (confirm('Are you shure you update the data?')) {
                    fetch("Controller/update_user.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ user_id: userId, email: email, username: username, user_role: userRole })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            alert("User updated successfully");
                            const user = this.users.find(user => user.user_id === userId);
                            if (user) {
                                user.email = email;
                                user.username = username;
                                user.user_role = userRole;
                            }
                        } else {
                            console.error("Error updating user:", data.error);
                        }
                    }).catch(error => console.error("Error:", error));
                } else {
                    console.log("update cancel");
                }
            }
        }
    }
</script>