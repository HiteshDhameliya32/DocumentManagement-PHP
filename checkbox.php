<!DOCTYPE html>
<html lang="en">

<?php $activeMenu = 'forms'; $activeItem = 'checkbox';?>

<!--..:: Importing Head Section ::..-->
<?php include "./partials/head.php" ?>

<body x-data="main" class="font-inter text-base antialiased font-medium relative vertical" :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.fullscreen ? 'full' : '',$store.app.mode]">
    <!--..:: Start Layout ::..-->
    <div class="bg-white dark:bg-dark text-dark dark:text-white">
        <!--..:: Start Menu Sidebar Olverlay ::..-->
        <div x-cloak class="fixed inset-0 bg-dark/90 dark:bg-white/5 backdrop-blur-sm z-40 lg:hidden" :class="{'hidden' : !$store.app.sidebar}" @click="$store.app.toggleSidebar()"></div>
        <!--..:: End Menu Sidebar Olverlay ::..-->

        <!--..:: Start Main Content ::..-->
        <div class="main-container flex mx-auto">
            <!--..:: Start Sidebar ::..-->
            <?php include "./partials/sidebar.php" ?>
            <!--..:: End sidebar ::..-->

            <!--..:: Start Content Area ::..-->
            <div class="main-content flex-1">
                <!--..:: Start Topbar ::..-->
                <?php include "./partials/topbar.php" ?>
                <!--..:: End Topbar ::..-->

                <!--..:: Start Content ::..-->
                <div class="h-[calc(100vh-60px)] relative overflow-y-auto overflow-x-hidden p-5 sm:p-7 space-y-5">
                    <!--..:: Start All Card ::..-->
                    <div class="flex flex-col gap-5 min-h-[calc(100vh-188px)] sm:min-h-[calc(100vh-204px)]">
                        <div class="grid grid-cols-1">
                            <div>
                                <ul class="flex flex-wrap items-center text-sm font-semibold space-x-2.5">
                                    <li class="flex items-center space-x-2.5 text-gray hover:text-dark dark:hover:text-white duration-300">
                                        <a href="javaScript:;">Forms</a>
                                        <svg class="text-gray/50" width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5" d="M1.33644 0H4.19579C4.60351 0 5.11318 0.264045 5.32903 0.589888L7.83532 4.3427C8.07516 4.70787 8.05119 5.2809 7.77538 5.6236L4.66949 9.5C4.44764 9.77528 3.96795 10 3.6022 10H1.33644C0.287156 10 -0.348385 8.92135 0.203241 8.08427L1.86409 5.59551C2.08594 5.26405 2.08594 4.72472 1.86409 4.39326L0.203241 1.90449C-0.348385 1.07865 0.293152 0 1.33644 0Z" fill="currentColor" />
                                        </svg>
                                    </li>
                                    <li>Checkbox</li>
                                </ul>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
                                <h2 class="text-base font-semibold mb-4">Checkbox Default</h2>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-primary" class="form-checkbox text-primary" checked="">
                                        <span class="text-sm">Primary</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-purple" class="form-checkbox text-purple" checked="">
                                        <span class="text-sm">Purple</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-success" class="form-checkbox text-success">
                                        <span class="text-sm">Success</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-warning" class="form-checkbox text-warning">
                                        <span class="text-sm">Warning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-danger" class="form-checkbox text-danger">
                                        <span class="text-sm">Danger</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-black" class="form-checkbox text-dark">
                                        <span class="text-sm">Black</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-muted" class="form-checkbox text-gray/20">
                                        <span class="text-sm">Muted</span>
                                    </label>
                                </div>
                                
                            </div>
                            <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
                                <h2 class="text-base font-semibold mb-4">Checkbox Rounded</h2>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-primary-2" class="form-checkbox rounded-full text-primary" checked="">
                                        <span class="text-sm">Primary</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-purple-2" class="form-checkbox rounded-full text-purple" checked="">
                                        <span class="text-sm">Purple</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-success-2" class="form-checkbox rounded-full text-success">
                                        <span class="text-sm">Success</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-warning-2" class="form-checkbox rounded-full text-warning">
                                        <span class="text-sm">Warning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-danger-2" class="form-checkbox rounded-full text-danger">
                                        <span class="text-sm">Danger</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-black-2" class="form-checkbox rounded-full text-dark">
                                        <span class="text-sm">Black</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-muted-2" class="form-checkbox rounded-full text-gray/20">
                                        <span class="text-sm">Muted</span>
                                    </label>
                                </div>

                            </div>
                            <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
                                <h2 class="text-base font-semibold mb-4">Checkbox Outline</h2>
                               <div class="grid grid-cols-1 gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-primary-3" class="form-checkbox outborder-primary" checked="">
                                        <span class="text-sm">Primary</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-purple-3" class="form-checkbox outborder-purple" checked="">
                                        <span class="text-sm">Purple</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-success-3" class="form-checkbox outborder-success">
                                        <span class="text-sm">Success</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-warning-3" class="form-checkbox outborder-warning">
                                        <span class="text-sm">Warning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-danger-3" class="form-checkbox outborder-danger">
                                        <span class="text-sm">Danger</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-black-3" class="form-checkbox outborder-dark">
                                        <span class="text-sm">Black</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-muted-3" class="form-checkbox outborder-gray">
                                        <span class="text-sm">Muted</span>
                                    </label>
                                </div>

                            </div>
                            <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
                                <h2 class="text-base font-semibold mb-4">Checkbox Rounded</h2>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-primary-4" class="form-checkbox rounded-full outborder-primary" checked="">
                                        <span class="text-sm">Primary</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-purple-4" class="form-checkbox rounded-full outborder-purple" checked="">
                                        <span class="text-sm">Purple</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-success-4" class="form-checkbox rounded-full outborder-success">
                                        <span class="text-sm">Success</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-warning-4" class="form-checkbox rounded-full outborder-warning">
                                        <span class="text-sm">Warning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-danger-4" class="form-checkbox rounded-full outborder-danger">
                                        <span class="text-sm">Danger</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-black-4" class="form-checkbox rounded-full outborder-dark">
                                        <span class="text-sm">Black</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-muted-4" class="form-checkbox rounded-full outborder-gray">
                                        <span class="text-sm">Muted</span>
                                    </label>
                                </div>
                                
                            </div>
                            <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
                                <h2 class="text-base font-semibold mb-4">Checkbox with text color</h2>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-primary-5" class="form-checkbox peer text-primary" checked="">
                                        <span class="text-sm peer-checked:text-primary">Primary</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-purple-5" class="form-checkbox peer text-purple" checked="">
                                        <span class="text-sm peer-checked:text-purple">Purple</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-success-5" class="form-checkbox peer text-success">
                                        <span class="text-sm peer-checked:text-success">Success</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-warning-5" class="form-checkbox peer text-warning">
                                        <span class="text-sm peer-checked:text-warning">Warning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-danger-5" class="form-checkbox peer text-danger">
                                        <span class="text-sm peer-checked:text-danger">Danger</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-dark-5" class="form-checkbox peer text-dark">
                                        <span class="text-sm peer-checked:text-dark">Black</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-gray-5" class="form-checkbox peer text-gray/20">
                                        <span class="text-sm peer-checked:text-gray">Muted</span>
                                    </label>
                                </div>
                                
                            </div>
                            <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
                                <h2 class="text-base font-semibold mb-4">Checkbox Outline</h2>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-primary-6" class="form-checkbox peer outborder-primary" checked="">
                                        <span class="text-sm peer-checked:text-primary">Primary</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-purple-6" class="form-checkbox peer outborder-purple" checked="">
                                        <span class="text-sm peer-checked:text-purple">Purple</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-success-6" class="form-checkbox peer outborder-success">
                                        <span class="text-sm peer-checked:text-success">Success</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-warning-6" class="form-checkbox peer outborder-warning">
                                        <span class="text-sm peer-checked:text-warning">Warning</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-danger-6" class="form-checkbox peer outborder-danger">
                                        <span class="text-sm peer-checked:text-danger">Danger</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-dark-6" class="form-checkbox peer outborder-dark">
                                        <span class="text-sm peer-checked:text-dark">Black</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="checkbox-gray-6" class="form-checkbox peer outborder-gray">
                                        <span class="text-sm peer-checked:text-gray">Muted</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--..:: End All Card ::..-->

                    <!--..:: Start Footer ::..-->
                    <?php include "./partials/footer.php" ?>
                    <!--..:: End Footer ::..-->
                </div>
                <!--..:: End Content ::..-->
            </div>
            <!--..:: End Content Area ::..-->
        </div>
    </div>
    <!--..:: End Layout ::..-->

    <!--..:: All javascirpt ::..-->
    <?php include "./partials/scripts.php" ?>
</body>

</html>