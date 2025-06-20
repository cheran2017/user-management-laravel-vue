<template>
    <Head title="Create User" />

    <div class="max-w-2xl mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">➕ Create User</h1>

        <form @submit.prevent="submit">
            <!-- Basic Info -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">First Name *</label>
                <input v-model="form.first_name" type="text" class="w-full border px-3 py-2 rounded" />
                <p v-if="form.errors.first_name" class="text-red-500 text-sm">{{ form.errors.first_name }}</p>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Last Name</label>
                <input v-model="form.last_name" type="text" class="w-full border px-3 py-2 rounded" />
                <p v-if="form.errors.last_name" class="text-red-500 text-sm">{{ form.errors.last_name }}</p>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Date of Birth *</label>
                <input v-model="form.dob" type="date" class="w-full border px-3 py-2 rounded" />
                <p v-if="form.errors.dob" class="text-red-500 text-sm">{{ form.errors.dob }}</p>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Gender *</label>
                <select v-model="form.gender" class="w-full border px-3 py-2 rounded">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <p v-if="form.errors.gender" class="text-red-500 text-sm">{{ form.errors.gender }}</p>
            </div>

            <!-- Address Section -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Addresses</h2>
                <div v-for="(address, index) in form.addresses" :key="index" class="border p-4 mb-4 rounded">
                    <div class="mb-2">
                        <label class="block mb-1 font-medium">Address Type *</label>
                        <select v-model="address.address_type" class="w-full border px-3 py-2 rounded">
                            <option value="home">Home</option>
                            <option value="work">Work</option>
                        </select>
                        <p v-if="form.errors[`addresses.${index}.address_type`]" class="text-red-500 text-sm">{{ form.errors[`addresses.${index}.address_type`] }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="block mb-1 font-medium">Door Number / Street</label>
                        <input v-model="address.door_street" type="text" class="w-full border px-3 py-2 rounded" />
                        <p v-if="form.errors[`addresses.${index}.door_street`]" class="text-red-500 text-sm">{{ form.errors[`addresses.${index}.door_street`] }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="block mb-1 font-medium">Landmark</label>
                        <input v-model="address.landmark" type="text" class="w-full border px-3 py-2 rounded" />
                        <p v-if="form.errors[`addresses.${index}.landmark`]" class="text-red-500 text-sm">{{ form.errors[`addresses.${index}.landmark`] }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="block mb-1 font-medium">City *</label>
                        <input v-model="address.city" type="text" class="w-full border px-3 py-2 rounded" />
                        <p v-if="form.errors[`addresses.${index}.city`]" class="text-red-500 text-sm">{{ form.errors[`addresses.${index}.city`] }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="block mb-1 font-medium">State *</label>
                        <input v-model="address.state" type="text" class="w-full border px-3 py-2 rounded" />
                        <p v-if="form.errors[`addresses.${index}.state`]" class="text-red-500 text-sm">{{ form.errors[`addresses.${index}.state`] }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="block mb-1 font-medium">Country *</label>
                        <input v-model="address.country" type="text" class="w-full border px-3 py-2 rounded" />
                        <p v-if="form.errors[`addresses.${index}.country`]" class="text-red-500 text-sm">{{ form.errors[`addresses.${index}.country`] }}</p>
                    </div>

                    <button type="button" @click="removeAddress(index)" class="mt-2 text-red-500 text-sm hover:underline">
                        🗑 Remove Address
                    </button>
                </div>

                <button type="button" @click="addAddress" class="bg-blue-500 text-white px-3 py-1 rounded">
                    ➕ Add Address
                </button>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                :disabled="form.processing"
            >
                ✅ Create User
            </button>
            <!-- Back Button -->
            <Link
                :href="route('users.index')"
                class="ml-2 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            >
                🔙 Back to List
            </Link>
        </form>
    </div>
</template>

<script setup>
import { Head, router, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    dob: '',
    gender: '',
    addresses: [
        {
            address_type: 'home',
            door_street: '',
            landmark: '',
            city: '',
            state: '',
            country: '',
        },
    ],
})

function addAddress() {
    form.addresses.push({
        address_type: 'home',
        door_street: '',
        landmark: '',
        city: '',
        state: '',
        country: '',
    })
}

function removeAddress(index) {
    form.addresses.splice(index, 1)
}

function submit() {
    form.post(route('users.store'))
}
</script>
