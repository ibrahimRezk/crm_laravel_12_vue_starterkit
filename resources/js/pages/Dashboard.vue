<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { dashboard } from '@/routes/index';
import { Head } from '@inertiajs/vue3';
import { Activity, Briefcase, DollarSign, Users } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';

interface Props {
    stats?: {
        total_contacts: number;
        total_deals: number;
        won_deals_value: number;
        active_deals: number;
    };
    recent_activities?: Array<{
        id: number;
        description: string;
        type: string;
        created_at: string;
        user: { name: string } | null;
        subject: { name: string; type: string } | null;
    }>;
}

const props = withDefaults(defineProps<Props>(), {
    stats: () => ({
        total_contacts: 0,
        total_deals: 0,
        won_deals_value: 0,
        active_deals: 0,
    }),
    recent_activities: () => [],
});

const { t } = useI18n();

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value);
};
</script>

<template>
    <Head :title="t('dashboard')" />

    <AppSidebarLayout
        :breadcrumbs="[{ title: t('dashboard'), href: dashboard() }]"
    >
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium">{{
                            t('Total Contacts')
                        }}</CardTitle>
                        <Users class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ stats.total_contacts }}
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium">{{
                            t('Total Deals')
                        }}</CardTitle>
                        <Briefcase class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ stats.total_deals }}
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium">{{
                            t('Won Deals Value')
                        }}</CardTitle>
                        <DollarSign class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ formatCurrency(stats.won_deals_value) }}
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium">{{
                            t('Active Deals')
                        }}</CardTitle>
                        <Activity class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ stats.active_deals }}
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
                <Card class="col-span-4">
                    <CardHeader>
                        <CardTitle>{{ t('Recent Activities') }}</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div
                            v-if="recent_activities.length === 0"
                            class="py-8 text-center text-muted-foreground"
                        >
                            {{ t('No recent activities.') }}
                        </div>
                        <div v-else class="space-y-8">
                            <div
                                v-for="activity in recent_activities"
                                :key="activity.id"
                                class="flex items-center"
                            >
                                <div class="space-y-1">
                                    <p class="text-sm leading-none font-medium">
                                        {{ activity.user?.name }}
                                        <span
                                            class="font-normal text-muted-foreground"
                                        >
                                            {{ t('performed') }}
                                            {{ activity.type }} {{ t('on') }}
                                            <span v-if="activity.subject"
                                                >{{ activity.subject.name }} ({{
                                                    activity.subject.type
                                                }})</span
                                            >
                                            <span v-else>{{
                                                t('Unknown Item')
                                            }}</span>
                                        </span>
                                    </p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ activity.description }}
                                    </p>
                                </div>
                                <div
                                    class="ml-auto text-xs font-medium text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            activity.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppSidebarLayout>
</template>
