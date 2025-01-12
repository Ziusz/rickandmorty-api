<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const characters = ref([]);

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleString('pl-PL', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
}

const fetchCharacters = async () => {
    try {
        const response = await axios.get('/api/v1/characters');
        characters.value = await response.data.data;
    } catch (error) {
        console.error('Occurred error: ', error);
    }
}

const listenForCharacterCreated = () => {
    try {
        Echo.channel('characters').listen('CharacterCreated', (character) => {
            characters.value.push(character);
        });
    } catch (error) {
        console.error('Error in WebSocket connection: ', error);
    }
}

onMounted(() => {
    fetchCharacters();
    listenForCharacterCreated();
})
</script>

<template>
    <div v-if="characters.length == 0" class="p-2">
        <span>No data to display.</span>
    </div>
    <table class="w-full bg-white overflow-hidden" v-else>
        <thead class="bg-blue-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last episode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Origin</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created at</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated at</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="character in characters" class="hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-900">{{ character.id }}</td>
                <td class="px-6 py-3 text-m font-medium text-gray-900">{{ character.name }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ character.status }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ character.location }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ character.last_episode }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ character.species }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ character.origin }}</td>
                <td class="px-6 py-3 text-xs text-gray-500">{{ formatDate(character.created_at) }}</td>
                <td class="px-6 py-3 text-xs text-gray-500">{{ formatDate(character.updated_at) }}</td>
            </tr>
        </tbody>
    </table>
</template>
