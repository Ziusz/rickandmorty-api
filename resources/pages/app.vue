<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const characters = ref([]);
const interval = 3000; // polling for every 3 seconds

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
    } finally {
        setTimeout(fetchCharacters, interval)
    }
}

onMounted(() => {
    fetchCharacters();
})
</script>

<template>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Location</th>
                <th>Last episode</th>
                <th>Species</th>
                <th>Origin</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="character in characters">
                <td>{{ character.id }}</td>
                <td>{{ character.name }}</td>
                <td>{{ character.status }}</td>
                <td>{{ character.location }}</td>
                <td>{{ character.last_episode }}</td>
                <td>{{ character.species }}</td>
                <td>{{ character.origin }}</td>
                <td>{{ formatDate(character.created_at) }}</td>
                <td>{{ formatDate(character.updated_at) }}</td>
            </tr>
        </tbody>
    </table>
</template>
