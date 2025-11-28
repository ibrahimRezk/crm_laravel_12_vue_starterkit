<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useI18n } from 'vue-i18n';
import { ChevronLeft } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import  deals  from '@/routes/deals';

const props = defineProps<{
    contacts: Array<{ id: number; name: string }>;
    users: Array<{ id: number; name: string }>;
}>();

const { t } = useI18n();

const form = useForm({
    title: '',
    value: '',
    stage: 'lead',
    contact_id: '',
    assigned_to: '',
});

const stages = ['lead', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];

const submit = () => {
    form.post(deals.store());
};
</script>

<template>
    <Head :title="t('Create Deal')" />

    <AppSidebarLayout
        :breadcrumbs="[
            { title: t('deals'), href: deals.index() },
            { title: t('Create Deal'), href: deals.create() },
        ]"
    >
        <div class="flex h-full flex-1 flex-col gap-4 p-4 max-w-2xl mx-auto w-full">
            <div class="flex items-center gap-2">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="deals.index()">
                        <ChevronLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <h1 class="text-xl font-semibold">{{ t('Create Deal') }}</h1>
            </div>

            <div class="rounded-md border p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="space-y-2">
                        <Label for="title">{{ t('Title') }}</Label>
                        <Input id="title" v-model="form.title" required />
                        <InputError :message="form.errors.title" />
                    </div>

                    <div class="space-y-2">
                        <Label for="value">{{ t('Value') }}</Label>
                        <Input id="value" type="number" step="0.01" v-model="form.value" required />
                        <InputError :message="form.errors.value" />
                    </div>

                    <div class="space-y-2">
                        <Label for="stage">{{ t('Stage') }}</Label>
                        <Select v-model="form.stage">
                            <SelectTrigger>
                                <SelectValue :placeholder="t('Select a stage')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="stage in stages" :key="stage" :value="stage">
                                    {{ t(stage) }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.stage" />
                    </div>

                    <div class="space-y-2">
                        <Label for="contact">{{ t('Contact') }}</Label>
                        <Select v-model="form.contact_id">
                            <SelectTrigger>
                                <SelectValue :placeholder="t('Select a contact')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="contact in contacts" :key="contact.id" :value="String(contact.id)">
                                    {{ contact.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                         <InputError :message="form.errors.contact_id" />
                    </div>

                    <div class="space-y-2">
                        <Label for="assigned_to">{{ t('Assigned To') }}</Label>
                        <Select v-model="form.assigned_to">
                            <SelectTrigger>
                                <SelectValue :placeholder="t('Select a user')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="user in users" :key="user.id" :value="String(user.id)">
                                    {{ user.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                         <InputError :message="form.errors.assigned_to" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <Button type="submit" :disabled="form.processing">
                            {{ t('Save') }}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppSidebarLayout>
</template>
