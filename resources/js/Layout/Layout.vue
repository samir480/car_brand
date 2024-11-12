<script setup>
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet'
import { CircleUser, Home, Menu, Package, Package2 } from 'lucide-vue-next'
import { Link, usePage } from '@inertiajs/vue3';
import { useToast } from '@/components/ui/toast/use-toast'
import { watch } from "vue";
import Toaster from '@/components/ui/toast/Toaster.vue';
const { toast } = useToast()

const page = usePage();

watch(
    page,
    (newValue, oldValue) => {

        // executed immediately, then again when `source` changes
        if (page.props.flash && page.props.flash.success) {

            toast({
                // severity: "success",
                title: page.props.flash.success
            });
        } else if (page.props.flash && page.props.flash.error) {
            toast({
                // severity: "error",
                title: page.props.flash.error
            });
        }

        if (page.props.flash && page.props.flash.info) {
            toast({
                // severity: "info",
                title: page.props.flash.info,
            });
        }
    },
    { immediate: true }
);

function checkActiveRoute(item_to) {
    const currentUrl = page.url; // Get the current URL from Inertia

    // Extract the path from item.to (full URL)
    const itemPath = new URL(item_to, window.location.origin).pathname;

    // Handle the case where currentUrl is the root ('/')
    if (currentUrl === '/' && itemPath === '/') {
        return true; // Both are root paths, return true
    }
    console.log(itemPath,currentUrl);
    
    // Handle the case where currentUrl is not root, match exact paths
    if (currentUrl.includes(itemPath) && itemPath!='/') {
        return true; // Exact match between the current route and the item route
    }

    // If none of the above cases match, return false
    return false;
}

</script>

<template>
    <div class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]">
        <div class="hidden border-r bg-muted/40 md:block">
            <div class="flex h-full max-h-screen flex-col gap-2">
                <div class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6">
                    <Link :href="route('dashboard')" class="flex items-center gap-2 font-semibold">
                    <Package2 class="h-6 w-6" />
                    <span class="">Car Brands</span>
                    </Link>
                </div>
                <div class="flex-1">
                    <nav class="grid items-start px-2 text-sm font-medium lg:px-4">
                        <Link :href="route('dashboard')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                            :class="{ 'bg-muted text-primary': checkActiveRoute(route('dashboard')) }">
                        <Home class="h-4 w-4" />
                        Dashboard
                        </Link>
                        <Link :href="route('brand.index')"
                            class="flex items-center gap-3 rounded-lg  px-3 py-2 transition-all hover:text-primary"
                            :class="{ 'bg-muted text-primary': checkActiveRoute(route('brand.index')) }">
                        <Package class="h-4 w-4" />
                        Brands
                        </Link>
                        <Link :href="route('model.index')"
                            class="flex items-center gap-3 rounded-lg  px-3 py-2 transition-all hover:text-primary"
                            :class="{ 'bg-muted text-primary': checkActiveRoute(route('model.index')) }">
                        <Package class="h-4 w-4" />
                        Models
                        </Link>
                    </nav>
                </div>

            </div>
        </div>
        <div class="flex flex-col">
            <header class="flex h-14 items-center gap-4 border-b bg-muted/40 px-4 lg:h-[60px] lg:px-6">
                <Sheet>
                    <SheetTrigger as-child>
                        <Button variant="outline" size="icon" class="shrink-0 md:hidden">
                            <Menu class="h-5 w-5" />
                            <span class="sr-only">Toggle navigation menu</span>
                        </Button>
                    </SheetTrigger>
                    <SheetContent side="left" class="flex flex-col">
                        <nav class="grid gap-2 text-lg font-medium">
                            <Link :href="route('dashboard')" class="flex items-center gap-2 text-lg font-semibold">
                            <Package2 class="h-6 w-6" />
                            <span class="sr-only">Car Brands</span>
                            </Link>
                            <Link :href="route('dashboard')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                                :class="{ 'bg-muted text-primary': checkActiveRoute(route('model.index')) }">
                            <Home class="h-5 w-5" />
                            Dashboard
                            </Link>
                            <Link :href="route('brand.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                                :class="{ 'bg-muted text-primary': checkActiveRoute(route('model.index')) }">
                            <Package class="h-5 w-5" />
                            Brands
                            </Link>
                            <Link :href="route('model.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                                :class="{ 'bg-muted text-primary': checkActiveRoute(route('model.index')) }">

                            <Package class="h-5 w-5" />
                            Brand Models
                            </Link>

                        </nav>

                    </SheetContent>
                </Sheet>
                <div class="w-full flex-1">
                </div>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="secondary" size="icon" class="rounded-full">
                            <CircleUser class="h-5 w-5" />
                            <span class="sr-only">Toggle user menu</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <!-- <DropdownMenuLabel>My Account</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem>Settings</DropdownMenuItem>
                        <DropdownMenuItem>Support</DropdownMenuItem>
                        <DropdownMenuSeparator /> -->
                        <DropdownMenuItem>Logout</DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </header>
            <main class="flex flex-1 flex-col gap-4 p-4 lg:gap-6 lg:p-6">
                <slot></slot>
            </main>
        </div>
    </div>
    <Toaster />
</template>