<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { useI18n } from 'vue-i18n';
import { ChevronLeft, Pencil, Plus } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import InputError from '@/components/InputError.vue';
import  contacts  from '@/routes/contacts';
import  activities  from '@/routes/activities';

const props = defineProps<{
    contact: {
        id: number;
        name: string;
        email: string;
        phone: string;
        company: string;
        assigned_to: { name: string } | null;
        deals: Array<{
            id: number;
            title: string;
            value: number;
            stage: string;
        }>;
        activities: Array<{
            id: number;
            type: string;
            description: string;
            created_at: string;
        }>;
    };
}>();

const { t } = useI18n();

const activityForm = useForm({
    type: 'call',
    description: '',
    due_date: '',
    subject_type: 'App\\Models\\Contact',
    subject_id: props.contact.id,
});

const submitActivity = () => {
    activityForm.post(activities.store(), {
        preserveScroll: true,
        onSuccess: () => activityForm.reset('description', 'due_date'),
    });
};
</script>

<template>
    <Head :title="contact.name" />

    <AppSidebarLayout
        :breadcrumbs="[
            { title: t('contacts'), href: contacts.index() },
            { title: contact.name, href: contacts.show(contact.id) },
        ]"
    >
        <div class="flex h-full flex-1 flex-col gap-4 p-4 max-w-4xl mx-auto w-full">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Button variant="ghost" size="icon" as-child>
                        <Link :href="contacts.index()">
                            <ChevronLeft class="h-4 w-4" />
                        </Link>
                    </Button>
                    <h1 class="text-xl font-semibold">{{ contact.name }}</h1>
                </div>
                <Button variant="outline" size="sm" as-child>
                    <Link :href="contacts.edit(contact.id)">
                        <Pencil class="mr-2 h-4 w-4" />
                        {{ t('Edit') }}
                    </Link>
                </Button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Contact Info -->
                <div class="md:col-span-1 space-y-6">
                    <div class="rounded-md border p-6 space-y-4">
                        <h2 class="font-semibold">{{ t('Contact Details') }}</h2>
                        <div class="space-y-1">
                            <div class="text-sm text-muted-foreground">{{ t('Email') }}</div>
                            <div>{{ contact.email }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-muted-foreground">{{ t('Phone') }}</div>
                            <div>{{ contact.phone || '-' }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-muted-foreground">{{ t('Company') }}</div>
                            <div>{{ contact.company || '-' }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-muted-foreground">{{ t('Assigned To') }}</div>
                            <div>{{ contact.assigned_to?.name || '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Related Items -->
                <div class="md:col-span-2">
                    <Tabs default-value="deals" class="w-full">
                        <TabsList class="w-full justify-start">
                            <TabsTrigger value="deals">{{ t('Deals') }}</TabsTrigger>
                            <TabsTrigger value="activities">{{ t('Activities') }}</TabsTrigger>
                        </TabsList>
                        <TabsContent value="deals" class="mt-4">
                            <div class="rounded-md border p-4">
                                <div v-if="contact.deals.length === 0" class="text-center text-muted-foreground py-8">
                                    {{ t('No deals found.') }}
                                </div>
                                <div v-else class="space-y-4">
                                    <div v-for="deal in contact.deals" :key="deal.id" class="flex items-center justify-between border-b pb-4 last:border-0 last:pb-0">
                                        <div>
                                            <div class="font-medium">{{ deal.title }}</div>
                                            <div class="text-sm text-muted-foreground">{{ t('Stage') }}: {{ deal.stage }}</div>
                                        </div>
                                        <div class="font-semibold">
                                            {{ deal.value }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </TabsContent>
                        <TabsContent value="activities" class="mt-4">
                            <div class="rounded-md border p-4 mb-4">
                                <h3 class="text-sm font-medium mb-2">{{ t('Add Activity') }}</h3>
                                <form @submit.prevent="submitActivity" class="space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="space-y-1">
                                            <Label for="type">{{ t('Type') }}</Label>
                                            <Select v-model="activityForm.type">
                                                <SelectTrigger>
                                                    <SelectValue />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem value="call">{{ t('Call') }}</SelectItem>
                                                    <SelectItem value="email">{{ t('Email') }}</SelectItem>
                                                    <SelectItem value="meeting">{{ t('Meeting') }}</SelectItem>
                                                    <SelectItem value="task">{{ t('Task') }}</SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <div class="space-y-1">
                                            <Label for="due_date">{{ t('Due Date') }}</Label>
                                            <Input id="due_date" type="datetime-local" v-model="activityForm.due_date" />
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <Label for="description">{{ t('Description') }}</Label>
                                        <Textarea id="description" v-model="activityForm.description" required />
                                    </div>
                                    <div class="flex justify-end">
                                        <Button type="submit" size="sm" :disabled="activityForm.processing">
                                            {{ t('Add Activity') }}
                                        </Button>
                                    </div>
                                </form>
                            </div>

                            <div class="rounded-md border p-4">
                                <div v-if="contact.activities.length === 0" class="text-center text-muted-foreground py-8">
                                    {{ t('No activities found.') }}
                                </div>
                                <div v-else class="space-y-4">
                                    <div v-for="activity in contact.activities" :key="activity.id" class="border-b pb-4 last:border-0 last:pb-0">
                                        <div class="flex items-center justify-between">
                                            <div class="font-medium capitalize">{{ activity.type }}</div>
                                            <div class="text-xs text-muted-foreground">{{ new Date(activity.created_at).toLocaleDateString() }}</div>
                                        </div>
                                        <div class="text-sm mt-1">{{ activity.description }}</div>
                                    </div>
                                </div>
                            </div>
                        </TabsContent>
                    </Tabs>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
