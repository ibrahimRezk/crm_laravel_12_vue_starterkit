<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useI18n } from 'vue-i18n';
import { Plus } from 'lucide-vue-next';
import  dealsRoute  from '@/routes/deals';
import { computed } from 'vue';
import { type BreadcrumbItem } from '@/types';



const props = defineProps<{
    deals: Array<{
        id: number;
        title: string;
        value: number;
        stage: string;
        contact: { name: string };
        assigned_to: { name: string } | null;
    }>;
}>();

const { t } = useI18n();

const stages = ['lead', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];

const dealsByStage = computed(() => {
    const grouped: Record<string, typeof props.deals> = {};
    stages.forEach(stage => {
        grouped[stage] = props.deals.filter(deal => deal.stage === stage);
    });
    return grouped;
});

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);
};

const breadcrumbItems: BreadcrumbItem[] = [
        { 
            title: t('deals'),
            href: dealsRoute.index().url 
        }
    ];

</script>

<template>
    <Head :title="t('deals')" />

    <AppSidebarLayout :breadcrumbs="breadcrumbItems">
        <Card  class=" w-full h-full">

        
        <div class="flex h-full flex-col gap-4 p-4 overflow-hidden">
            <div class="flex items-center justify-between shrink-0">
                <h1 class="text-xl font-semibold">{{ t('Deals Pipeline') }}</h1>
                <Button as-child>
                    <Link :href="dealsRoute.create()">
                        <Plus class="mr-2 h-4 w-4" />
                        {{ t('Add Deal') }}
                    </Link>
                </Button>
            </div>

            <div class="flex-1 overflow-x-auto">
                <div class="flex h-full gap-4 min-w-max pb-4">
                    <div v-for="stage in stages" :key="stage" class="w-80 flex flex-col gap-4 rounded-lg bg-muted/50 p-4">
                        <div class="flex items-center justify-between font-semibold capitalize">
                            {{ t(stage) }}
                            <span class="text-xs text-muted-foreground bg-background px-2 py-0.5 rounded-full border">
                                {{ dealsByStage[stage].length }}
                            </span>
                        </div>

                        <div class="flex-1 flex flex-col gap-3 overflow-y-auto">
                            <Card v-for="deal in dealsByStage[stage]" :key="deal.id" class="cursor-pointer hover:shadow-md transition-shadow">
                                <CardHeader class="p-4 pb-2">
                                    <CardTitle class="text-sm font-medium">{{ deal.title }}</CardTitle>
                                </CardHeader>
                                <CardContent class="p-4 pt-0 space-y-2">
                                    <div class="text-lg font-bold text-primary">
                                        {{ formatCurrency(deal.value) }}
                                    </div>
                                    <div class="text-xs text-muted-foreground flex justify-between">
                                        <span>{{ deal.contact.name }}</span>
                                        <span v-if="deal.assigned_to">{{ deal.assigned_to.name }}</span>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </Card>
    </AppSidebarLayout>
</template>
