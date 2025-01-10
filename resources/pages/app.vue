<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const characters = ref([]);
const interval = 3000; // polling for every 3 seconds

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
            </tr>
        </tbody>
    </table>
</template>
