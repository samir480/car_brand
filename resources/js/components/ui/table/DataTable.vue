<script setup>
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

import ChevronLeftIcon from '~icons/radix-icons/chevron-left'
import ChevronRightIcon from '~icons/radix-icons/chevron-right'

import DoubleArrowLeftIcon from '~icons/radix-icons/double-arrow-left'
import DoubleArrowRightIcon from '~icons/radix-icons/double-arrow-right'
import Button from '../button/Button.vue';
import DataTableDropDown from './DataTableDropDown.vue';
import Input from '../input/Input.vue';

const props = defineProps({
  columns: Array,
  actions: Array,
  only: Array,
  data: Object,
  search: String
})
const search = ref(props.search)
const per_page = ref(props.data.per_page)
const page = usePage()
const pageSizeOptions = [10, 20, 30, 40, 50]

const loadData = () => {
  setTimeout(() => {
    router.get(page.url, { per_page: per_page.value, search: search.value }, { only: props.only, preserveState: true, preserveScroll: true });
  }, 500); // Adjust the delay as needed (in ms)
}


watch([search, per_page], ([newSearch, newPerPage], [oldSearch, oldPerPage]) => {
  loadData()
}
);



</script>

<template>
  <div class="space-y-4">
    <!-- search -->
    <div class="flex items-center py-4">
      <Input class="max-w-sm" placeholder="Search..." v-model="search" />
    </div>

    <div class="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead v-for="column in columns">
              {{ column.label }}
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="data.data?.length">
            <TableRow v-for="row in data.data" :key="row.id" class="hover:bg-gray-100 transition-colors">
              <TableCell v-for="column in columns" :key="column.key" :aria-label="column.label">
                <!-- Allow custom rendering via scoped slots if needed -->

                <span v-html="column.render ? column.render(row) : row[column.key]" :name="`cell-${column.key}`"
                  :row="row" :value="row[column.key]" v-if="column.key != 'actions'" />

                <DataTableDropDown :name="`cell-${column.key}`" :row="row" :actions="actions" v-else />

              </TableCell>
            </TableRow>
          </template>

          <!-- No Results Row -->
          <TableRow v-else>
            <TableCell :colspan="columns.length" class="h-24 text-center">
              No results found.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>

    <!-- pagination -->
    <div class="flex items-center justify-between px-2">
      <div class="flex-1 text-sm text-muted-foreground">
        {{ data.from }}-{{ data.to }} of {{ data.total }} rows displayed.
      </div>

      <div class="flex items-center space-x-6 lg:space-x-8">
        <!-- Rows per page selector -->
        <div class="flex items-center space-x-2">
          <p class="text-sm font-medium">Rows per page</p>
          <select class="h-8 w-[70px] border rounded-md p-1" v-model="per_page">
            <option v-for="option in pageSizeOptions" :key="option" :value="option">
              {{ option }}
            </option>
          </select>


          <!-- <Select :value="per_page" @update:model-value="setPageSize">
            <SelectTrigger class="h-8 w-[70px]">
              <SelectValue :placeholder="`${per_page}`" />
            </SelectTrigger>
            <SelectContent side="top">
              <SelectItem v-for="pageSize in [10, 20, 30, 40, 50]" :key="pageSize" :value="`${pageSize}`">
                {{ pageSize }}
              </SelectItem>
            </SelectContent>
          </Select> -->


        </div>

        <!-- Page number and total pages -->
        <div class="flex w-[100px] items-center justify-center text-sm font-medium">
          Page {{ data.current_page }} of {{ data.last_page }}
        </div>

        <!-- Pagination buttons -->
        <div class="flex items-center space-x-2">
          <Link :href="data.first_page_url" v-if="data.current_page !== 1" preserve-state preserve-scroll>
          <Button variant="outline" class="hidden h-8 w-8 p-0 lg:flex">
            <span class="sr-only">Go to first page</span>
            <DoubleArrowLeftIcon class="h-4 w-4" />
          </Button>
          </Link>

          <Button variant="outline" class="hidden h-8 w-8 p-0 lg:flex" :disabled="true" v-else>
            <span class="sr-only">Go to first page</span>
            <DoubleArrowLeftIcon class="h-4 w-4" />
          </Button>


          <Link :href="data.prev_page_url" v-if="data.current_page !== 1" preserve-state preserve-scroll>
          <Button variant="outline" class="h-8 w-8 p-0">
            <span class="sr-only">Go to previous page</span>
            <ChevronLeftIcon class="h-4 w-4" />
          </Button>
          </Link>


          <Button variant="outline" class="h-8 w-8 p-0" :disabled="true" v-else>
            <span class="sr-only">Go to previous page</span>
            <ChevronLeftIcon class="h-4 w-4" />
          </Button>

          <Link :href="data.next_page_url" v-if="data.current_page !== data.last_page" preserve-state preserve-scroll>
          <Button variant="outline" class="h-8 w-8 p-0">
            <span class="sr-only">Go to next page</span>
            <ChevronRightIcon class="h-4 w-4" />
          </Button>
          </Link>

          <Button variant="outline" class="h-8 w-8 p-0" :disabled="true" v-else>
            <span class="sr-only">Go to next page</span>
            <ChevronRightIcon class="h-4 w-4" />
          </Button>


          <Link :href="data.last_page_url" v-if="data.current_page !== data.last_page" preserve-state preserve-scroll>
          <Button variant="outline" class="hidden h-8 w-8 p-0 lg:flex">
            <span class="sr-only">Go to last page</span>
            <DoubleArrowRightIcon class="h-4 w-4" />
          </Button>
          </Link>

          <Button variant="outline" class="hidden h-8 w-8 p-0 lg:flex" :disabled="true" v-else>
            <span class="sr-only">Go to last page</span>
            <DoubleArrowRightIcon class="h-4 w-4" />
          </Button>

        </div>
      </div>
    </div>

  </div>
</template>