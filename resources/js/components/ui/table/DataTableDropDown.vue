<script setup>
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { MoreHorizontal } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3';

defineProps({
    name: String,
    row: Object,
    actions: Array,
})


const action_fn = (id,action) => {
    router.visit(route(action.route,id),{
        method: action.method,
    });
}


</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="w-8 h-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem v-for="action in actions" @click="action_fn(row.id,action)">{{ action.label }}</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>