<script setup lang="ts">
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { NavItem } from '@/types';
import AppShell from '@/components/AppShell.vue';
import AppContent from '@/components/AppContent.vue';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <AppShell variant="sidebar">
    <Sidebar collapsible="icon" variant="inset">
        <div style="display:flex; width: 100%;height: 100%;">
        <div style="width: 20%; background-color: greenyellow;">
            <h1 style="flex: auto; color: black;">Ini sidebar 2</h1>
        </div>
        <div style="flex: 1;"> 
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>
        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
        </SidebarFooter>
    </div>
    </div>
    </Sidebar>
    <div style="display: flex; width: 100%; height: 100vh;flex-direction: column;">
        <div style="height: 80px; width: 100%;flex: none;">
            <h1 style="font-size: 50px; text-align: center;">Judul Group Chat</h1>
        </div>
        <div style="flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            background-color: white;
            overflow-y: auto;">
            <slot />
        </div>
        <div style="height: 65px;width: 100%; background-color: darkgray;flex: none;">
        </div>
    </div>
    </AppShell>
</template>
