<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useI18n } from 'vue-i18n';
import { ref, watch } from 'vue';
import { debounce } from 'lodash-es';
import { Plus, Search, Pencil, Trash } from 'lucide-vue-next';
import  contactsRoute  from '@/routes/contacts';

const props = defineProps<{
    contacts: {
        data: Array<{
            id: number;
            name: string;
            email: string;
            phone: string;
            company: string;
            assigned_to: { name: string } | null;
        }>;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
    };
    filters: {
        search: string;
    };
}>();

const { t } = useI18n();
const search = ref(props.filters.search);

watch(
    search,
    debounce((value: string) => {
        router.get(
            contactsRoute.index(),
            { search: value },
            { preserveState: true, replace: true },
        );
    }, 300),
);

const deleteContact = (id: number) => {
    if (confirm(t('Are you sure?'))) {
        router.delete(contactsRoute.destroy(id));
    }
};
</script>

<template>
    <Head :title="t('contacts')" />

    <AppSidebarLayout :breadcrumbs="[{ title: t('contacts'), href: contactsRoute.index() }]">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <div class="relative w-full max-w-sm items-center">
                    <Input
                        v-model="search"
                        type="text"
                        :placeholder="t('Search...')"
                        class="pl-10"
                    />
                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                        <Search class="size-4 text-muted-foreground" />
                    </span>
                </div>
                <Button as-child>
                    <Link :href="contactsRoute.create()">
                        <Plus class="mr-2 h-4 w-4" />
                        {{ t('Add Contact') }}
                    </Link>
                </Button>
            </div>

            <div class="rounded-md border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>{{ t('Name') }}</TableHead>
                            <TableHead>{{ t('Email') }}</TableHead>
                            <TableHead>{{ t('Phone') }}</TableHead>
                            <TableHead>{{ t('Company') }}</TableHead>
                            <TableHead>{{ t('Assigned To') }}</TableHead>
                            <TableHead class="text-right">{{ t('Actions') }}</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="contact in contacts.data" :key="contact.id">
                            <TableCell class="font-medium">{{ contact.name }}</TableCell>
                            <TableCell>{{ contact.email }}</TableCell>
                            <TableCell>{{ contact.phone }}</TableCell>
                            <TableCell>{{ contact.company }}</TableCell>
                            <TableCell>{{ contact.assigned_to?.name || '-' }}</TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="icon" as-child>
                                        <Link :href="contactsRoute.edit(contact.id)">
                                            <Pencil class="h-4 w-4" />
                                        </Link>
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        class="text-destructive"
                                        @click="deleteContact(contact.id)"
                                    >
                                        <Trash class="h-4 w-4" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="contacts.data.length === 0">
                            <TableCell colspan="6" class="h-24 text-center">
                                {{ t('No results.') }}
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-end space-x-2 py-4" v-if="contacts.links.length > 3">
                <div class="flex-1 text-sm text-muted-foreground">
                    <!-- Showing x of y results -->
                </div>
                <div class="space-x-2">
                     <template v-for="(link, key) in contacts.links" :key="key">
                        <Button
                            v-if="link.url"
                            :variant="link.active ? 'default' : 'outline'"
                            size="sm"
                            as-child
                        >
                            <Link :href="link.url" v-html="link.label" />
                        </Button>
                        <span v-else v-html="link.label" class="px-2 text-sm text-muted-foreground"></span>
                    </template>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
