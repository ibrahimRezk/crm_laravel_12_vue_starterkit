<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import {Form , Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useI18n } from 'vue-i18n';
import { ChevronLeft } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import  deals  from '@/routes/deals';
import { store } from '@/routes/deals';
import { BreadcrumbItem } from '@/types';
import { Card } from '@/components/ui/card';


defineProps<{
    contacts: Array<{ id: number; name: string }>;
    users: Array<{ id: number; name: string }>;
}>();

const { t } = useI18n();

const stages = ['lead', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];


const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: t('deals'),
        href: deals.index().url,
    },
    {
        title: t('Create Deal'),
        href: deals.create().url,
    },
];



</script>

<template>
    <Head :title="t('Create Deal')" />

    <AppSidebarLayout
        :breadcrumbs="breadcrumbItems"
    >
            <Card>

        <div class="flex h-full flex-1 flex-col gap-4 p-4 max-w-2xl mx-auto w-full bg-background rounded-xl">
            <div class="flex items-center gap-2">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="deals.index()">
                        <ChevronLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <h1 class="text-xl font-semibold">{{ t('Create Deal') }}</h1>
            </div>

            <div class="rounded-md border p-6">
                <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="space-y-4"
        >


                    <div class="space-y-2">
                        <Label for="title">{{ t('Title') }}</Label>
                        <Input id="title" name="title" required />
                        <InputError :message="errors.title" />
                    </div>

                    <div class="space-y-2">
                        <Label for="value">{{ t('Value') }}</Label>
                        <Input id="value" type="number" step="0.01" name="value" required />
                        <InputError :message="errors.value" />
                    </div>

                    <div class="space-y-2"> 
                        <Label for="stage">{{ t('Stage') }}</Label>
                        <Select name="stage">
                            <SelectTrigger>
                                <SelectValue :placeholder="t('Select a stage')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="stage in stages" :key="stage" :value="stage">
                                    {{ t(stage) }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="errors.stage" />
                    </div>

                    <div class="space-y-2">
                        <Label for="contact">{{ t('Contact') }}</Label>
                        <Select name="contact_id">
                            <SelectTrigger>
                                <SelectValue :placeholder="t('Select a contact')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="contact in contacts" :key="contact.id" :value="String(contact.id)">
                                    {{ contact.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                         <InputError :message="errors.contact_id" />
                    </div>

                    <div class="space-y-2">
                        <Label for="assigned_to">{{ t('Assigned To') }}</Label>
                        <Select name="assigned_to">
                            <SelectTrigger>
                                <SelectValue :placeholder="t('Select a user')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="user in users" :key="user.id" :value="String(user.id)">
                                    {{ user.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                         <InputError :message="errors.assigned_to" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <Button type="submit" :disabled="processing">
                            {{ t('Save') }}
                        </Button>
                    </div>
                </Form>
            </div>
        </div>
        </Card>
    </AppSidebarLayout>
</template>
