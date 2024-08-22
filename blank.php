<!DOCTYPE html>
<html lang="en">

<?php $activeMenu = 'pages'; $activeItem = 'blank';?>

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
                        <div class="grid grid-cols-1 gap-5">
                            <div class="bg-white dark:bg-dark dark:border-gray/20 border-2 border-lightgray/10 p-5 rounded-lg">
                                <h2 class="text-base font-semibold mb-4">Card Title</h2>

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