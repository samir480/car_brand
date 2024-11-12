<script setup>
import Button from '@/components/ui/button/Button.vue';
import Layout from '@/Layout/Layout.vue';
import DataTable from '@/components/ui/table/DataTable.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  brands: Object,
  search: String,
})

const search = computed(() => props.search || '');

const Columns = [
  { key: 'id', label: 'ID' },
  { key: 'name', label: 'Name' },
  {
    key: 'logo', label: 'Logo',
    render: (row) => `<img src="${row.logo}" alt="Logo" style="width: 50px; height: auto;" />` // Custom render logic for image
  },
  { key: 'actions' },
]
const Actions = [
  { route: 'brand.edit', label: 'Edit', method: 'get' },
  { route: 'brand.destroy', label: 'Delete', method: 'delete' }
]
</script>

<template>
  <Layout>

    <div class="flex-1 space-y-4 p-8 pt-6">
      <div class="flex items-center justify-between space-y-2">
        <h2 class="text-3xl font-bold tracking-tight">
          Brands
        </h2>
        <div class="flex items-center space-x-2">
          <Link :href="route('brand.create')"><Button>Add Brand</Button></Link>
        </div>
      </div>

      <div class="flex flex-1 items-center justify-center rounded-lg border border-dashed shadow-sm"
        v-if="!brands.data.length && search == ''">
        <div class="flex flex-col items-center gap-1 text-center">
          <h3 class="text-2xl font-bold tracking-tight">
            You have no brands
          </h3>
          <Link :href="route('brand.create')">
          <Button class="mt-4">
            Add Brand
          </Button>
          </Link>
        </div>
      </div>

      <DataTable :columns="Columns" :data="brands" :actions="Actions" :search="search" :only="['brands']" v-else />
    </div>
  </Layout>
</template>