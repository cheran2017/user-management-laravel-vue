<template>
    <!-- ✅ Success Toast -->
    <div
        v-if="flash.success && showToast"
        class="fixed top-6 right-6 bg-green-500 text-white px-4 py-2 rounded shadow z-50 transition-all duration-500 ease-out"
    >
        ✅ {{ flash.success }}
        <button @click="showToast = false" class="ml-2 font-bold">✖</button>
    </div>

    <!-- ❌ Error Toast -->
    <div
        v-if="flash.error && showToast"
        class="fixed top-6 right-6 bg-red-500 text-white px-4 py-2 rounded shadow z-50 transition-all duration-500 ease-out"
    >
        ❌ {{ flash.error }}
        <button @click="showToast = false" class="ml-2 font-bold">✖</button>
    </div>

    <Head title="Users" />

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">👥 User List</h1>

        <!-- 🔍 Search and ➕ Create Button -->
        <form @submit.prevent="submitSearch" class="mb-6 flex flex-wrap items-center gap-2">
            <input
                v-model="search"
                type="text"
                placeholder="Search by name..."
                class="px-4 py-2 border rounded-md flex-1 min-w-[200px]"
            />
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
            >
                🔍 Search
            </button>
            <Link
                :href="route('users.create')"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
            >
                ➕ Create New User
            </Link>
        </form>

        <!-- 🧾 Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-md">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">First Name</th>
                        <th class="py-2 px-4 border-b">Last Name</th>
                        <th class="py-2 px-4 border-b">Date of Birth</th>
                        <th class="py-2 px-4 border-b">Gender</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ user.first_name }}</td>
                        <td class="py-2 px-4 border-b">{{ user.last_name }}</td>
                        <td class="py-2 px-4 border-b">{{ user.dob }}</td>
                        <td class="py-2 px-4 border-b capitalize">{{ user.gender }}</td>
                        <td class="py-2 px-4 border-b">
                            <Link
                                :href="route('users.edit', user.id)"
                                class="text-blue-600 hover:underline mr-4"
                            >
                                ✏️ Edit
                            </Link>
                            <button
                                @click="deleteUser(user.id)"
                                class="text-red-600 hover:underline"
                            >
                                🗑 Delete
                            </button>
                        </td>
                    </tr>
                    <tr v-if="users.data.length === 0">
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 📄 Pagination -->
        <div class="mt-6 flex justify-center flex-wrap gap-2">
            <template v-for="link in users.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="px-3 py-1 rounded-md border"
                    :class="{
                        'bg-blue-500 text-white': link.active,
                        'bg-white text-black': !link.active,
                    }"
                    v-html="link.label"
                />
                <span
                    v-else
                    class="px-3 py-1 rounded-md border text-gray-400"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue'

const flash = computed(() => usePage().props.flash || {})
const showToast = ref(true)

onMounted(() => {
  if (flash.value.success || flash.value.error) {
    setTimeout(() => {
      showToast.value = false
    }, 3000)
  }
})

const props = defineProps({
    users: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

function submitSearch() {
    router.get('/users', { search: search.value }, { preserveState: true, replace: true });
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(route('users.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                showToast.value = true
            },
        });
    }
}

</script>
