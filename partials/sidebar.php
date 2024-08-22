<?php
include __DIR__ . '/../Authentication/db_connect.php';

// Assume $username is correctly set
$username = $_SESSION['username'];

$query = "SELECT `id`, `name`, `description`, `create_date`, `update_date`, `create_by` FROM `category`";
$result = $conn->query($query);

if ($result) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    $categories = [];
}
?>



<script>
    let categories = <?php echo json_encode($categories); ?>;
</script>
<nav
    class="sidebar fixed z-50 flex-none w-[226px] border-r-2 border-lightgray/[8%] dark:border-gray/20 transition-all duration-300">
    <div class="bg-white dark:bg-dark h-full">
        <div class="p-3.5">
            <a href="index.php" class="main-logo w-full">
                <img src="assets/images/logo-dark.svg" class="mx-auto dark-logo h-8 logo dark:hidden" alt="logo" />
                <img src="assets/images/logo-light.svg" class="mx-auto light-logo h-8 logo hidden dark:block"
                    alt="logo" />
                <img src="assets/images/logo-icon.svg" class="logo-icon h-8 mx-auto hidden" alt="">
            </a>
        </div>
        <div class="flex items-center gap-2.5 py-2.5 pe-2.5">
            <div class="h-[2px] bg-lightgray/10 dark:bg-gray/50 block flex-1"></div>
            <button type="button" class="shrink-0 btn-toggle hover:text-primary duration-300"
                @click="$store.app.toggleSidebar()">
                <svg class="w-3.5" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.2"
                        d="M5.46133 6.00002L11.1623 12L12.4613 10.633L8.05922 6.00002L12.4613 1.36702L11.1623 0L5.46133 6.00002Z"
                        fill="currentColor" />
                    <path d="M0 6.00002L5.70101 12L7 10.633L2.59782 6.00002L7 1.36702L5.70101 0L0 6.00002Z"
                        fill="currentColor" />
                </svg>
            </button>
        </div>
        <div class="h-[calc(100vh-93px)] overflow-y-auto overflow-x-hidden space-y-16 px-4 pt-2 pb-4">
            <ul class="relative flex flex-col gap-1 text-sm"
                x-data="{ activeMenu: '<?php echo $activeMenu; ?>', activeItem: '<?php echo $activeItem; ?>' }">
                <li class="menu nav-item">
                    <a href="javaScript:;" class="nav-link group items-center justify-between"
                        :class="{'active' : activeMenu === 'dashboard'}"
                        @click="activeMenu === 'dashboard' ? activeMenu = null : activeMenu = 'dashboard'">
                        <div class="flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M10.8939 22H13.1061C16.5526 22 18.2759 22 19.451 20.9882C20.626 19.9764 20.8697 18.2827 21.3572 14.8952L21.6359 12.9579C22.0154 10.3208 22.2051 9.00229 21.6646 7.87495C21.1242 6.7476 19.9738 6.06234 17.6731 4.69182L17.6731 4.69181L16.2882 3.86687C14.199 2.62229 13.1543 2 12 2C10.8457 2 9.80104 2.62229 7.71175 3.86687L6.32691 4.69181L6.32691 4.69181C4.02619 6.06234 2.87583 6.7476 2.33537 7.87495C1.79491 9.00229 1.98463 10.3208 2.36407 12.9579L2.64284 14.8952C3.13025 18.2827 3.37396 19.9764 4.54903 20.9882C5.72409 22 7.44737 22 10.8939 22Z"
                                    fill="currentColor" />
                                <path
                                    d="M9.44666 15.397C9.11389 15.1504 8.64418 15.2202 8.39752 15.5529C8.15086 15.8857 8.22067 16.3554 8.55343 16.6021C9.52585 17.3229 10.7151 17.7496 12 17.7496C13.285 17.7496 14.4742 17.3229 15.4467 16.6021C15.7794 16.3554 15.8492 15.8857 15.6026 15.5529C15.3559 15.2202 14.8862 15.1504 14.5534 15.397C13.8251 15.9369 12.9459 16.2496 12 16.2496C11.0541 16.2496 10.175 15.9369 9.44666 15.397Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="pl-1.5">Dashboard</span>
                        </div>
                        <div class="w-4 h-4 flex items-center justify-center dropdown-icon"
                            :class="{'!rotate-180' : activeMenu === 'dashboard'}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                                <path
                                    d="M11.9997 13.1714L16.9495 8.22168L18.3637 9.63589L11.9997 15.9999L5.63574 9.63589L7.04996 8.22168L11.9997 13.1714Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                    </a>
                    <ul x-cloak x-show="activeMenu === 'dashboard'" x-collapse class="sub-menu flex flex-col gap-1">
                        <li><a :class="{'active': activeItem === 'analysis'}" href="index.php">Analysis</a></li>
                    </ul>
                </li>
                <!-- Other list items -->
                <h2 class="pt-3.5 pb-2.5 text-gray text-xs">More</h2>
                <!-- this is for admin sidebar -->
                <?php if ($userRole === 3): ?>
                    <li class="menu nav-item">
                        <a href="javaScript:;" class="nav-link group items-center justify-between"
                            :class="{'active' : activeMenu === 'Manage'}"
                            @click="activeMenu === 'Manage' ? activeMenu = null : activeMenu = 'Manage'">
                            <div class="flex items-center">
                                <svg width="24" height="24" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.2"
                                        d="M17.5001 2.5C17.9603 2.5 18.3334 2.8731 18.3334 3.33333V16.6667C18.3334 17.1269 17.9603 17.5 17.5001 17.5H2.50008C2.03985 17.5 1.66675 17.1269 1.66675 16.6667V3.33333C1.66675 2.8731 2.03985 2.5 2.50008 2.5H17.5001Z"
                                        fill="currentColor" />
                                    <path
                                        d="M17.5001 2.5C17.9603 2.5 18.3334 2.8731 18.3334 3.33333V16.6667C18.3334 17.1269 17.9603 17.5 17.5001 17.5H2.50008C2.03985 17.5 1.66675 17.1269 1.66675 16.6667V3.33333C1.66675 2.8731 2.03985 2.5 2.50008 2.5H17.5001ZM16.6667 13.3333H3.33341V15.8333H16.6667V13.3333ZM6.66675 4.16667H3.33341V11.6667H6.66675V4.16667ZM11.6667 4.16667H8.33341V11.6667H11.6667V4.16667ZM16.6667 4.16667H13.3334V11.6667H16.6667V4.16667Z"
                                        fill="currentColor" />
                                </svg>
                                <span class="pl-1.5">Manage</span>
                            </div>
                            <div class="w-4 h-4 flex items-center justify-center dropdown-icon"
                                :class="{'!rotate-180' : activeMenu === 'Manage'}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                                    <path
                                        d="M11.9997 13.1714L16.9495 8.22168L18.3637 9.63589L11.9997 15.9999L5.63574 9.63589L7.04996 8.22168L11.9997 13.1714Z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </a>
                        <ul x-cloak x-show="activeMenu === 'Manage'" x-collapse class="sub-menu flex flex-col gap-1">
                            <li><a :class="{'active': activeItem === 'role_management'}" href="role_management.php">Role
                                </a></li>
                        </ul>
                        <ul x-cloak x-show="activeMenu === 'Manage'" x-collapse class="sub-menu flex flex-col gap-1">
                            <li><a :class="{'active': activeItem === 'category'}" href="category.php">Category
                                </a></li>
                        </ul>
                        <ul x-cloak x-show="activeMenu === 'Manage'" x-collapse class="sub-menu flex flex-col gap-1">
                            <li><a :class="{'active': activeItem === 'extension'}" href="extension.php">Extension
                                </a></li>
                        </ul>
                        <ul x-cloak x-show="activeMenu === 'Manage'" x-collapse class="sub-menu flex flex-col gap-1">
                            <li><a :class="{'active': activeItem === 'file'}" href="file.php">Files
                                </a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- this is for users sidebar -->
                <?php if ($userRole === 1): ?>
                    <li class="menu nav-item">
                        <a href="javaScript:;" class="nav-link group items-center justify-between"
                            :class="{'active' : activeMenu === 'Reports'}"
                            @click="activeMenu === 'Reports' ? activeMenu = null : activeMenu = 'Reports'">
                            <div class="flex items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9 2C7.89543 2 7 2.89543 7 4V20C7 21.1046 7.89543 22 9 22H19C20.1046 22 21 21.1046 21 20V6L16 2H9Z"
                                        fill="currentColor" opacity="0.1" />
                                    <path
                                        d="M9 2H16L21 6V20C21 21.1046 20.1046 22 19 22H9C7.89543 22 7 21.1046 7 20V4C7 2.89543 7.89543 2 9 2Z"
                                        stroke="currentColor" stroke-width="2" />
                                    <path d="M16 2V6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 12H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M12 16H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M7 8H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <circle cx="8.5" cy="18.5" r="1.5" fill="currentColor" />
                                    <path d="M10.5 19.5H18.5" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>

                                <span class="pl-1.5">Reports</span>
                            </div>
                            <div class="w-4 h-4 flex items-center justify-center dropdown-icon"
                                :class="{'!rotate-180' : activeMenu === 'Reports'}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                                    <path
                                        d="M11.9997 13.1714L16.9495 8.22168L18.3637 9.63589L11.9997 15.9999L5.63574 9.63589L7.04996 8.22168L11.9997 13.1714Z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </a>
                        <ul x-cloak x-show="activeMenu === 'Reports'" x-collapse class="sub-menu flex flex-col gap-1">
                            <template x-for="category in categories" :key="category.id">
                                <li>
                                    <a :class="{'active': activeItem === category.id}"
                                        :href="'reports.php?category=' + encodeURIComponent(category.id)">
                                        <span x-text="category.name"></span>
                                    </a>
                                </li>
                            </template>

                        </ul>

                    </li>
                <?php endif; ?>
            </ul>
            <div class="bg-primary p-[18px] relative sidebar-upgrade rounded-md">
                <div class="relative z-10">
                    <div class="flex items-center gap-2">
                        <img src="assets/images/upgrade.png" alt="" class="rounded-full">
                        <div class="text-white">
                            <h5 class="font-bold text-base">Upgrade Plan</h5>
                            <p class="text-xs opacity-50">Get Best offer</p>
                        </div>
                    </div>
                    <div class="mt-[30px]">
                        <a href="javascript:;" class="btn bg-success text-white">Upgrade Plan</a>
                    </div>
                </div>
                <div class="z-0">
                    <img src="assets/images/upgrade-illustrator.png" class="absolute right-0 bottom-0" alt="">
                </div>
            </div>
        </div>
    </div>
</nav>