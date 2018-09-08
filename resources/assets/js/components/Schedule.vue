<template>
    <v-flex sm12>
        <div>
        <h1 class="font-weight-light">Jadwal</h1>
        <v-flex sm6 d-flex>
            <v-select
            :items="items"
            label="Sesuaikan kebutuhan Anda"
            solo
            ></v-select>
        </v-flex>

        <v-vlex sm12>
            <v-data-table
                :headers="headers"
                :items="desserts"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.name }}</td>
                    <td class="text-xs-right">{{ props.item.calories }}</td>
                    <td class="text-xs-right">{{ props.item.fat }}</td>
                    <td class="text-xs-right">{{ props.item.carbs }}</td>
                    <td class="text-xs-right">{{ props.item.protein }}</td>
                    <td class="text-xs-right">{{ props.item.iron }}</td>
                </template>
            </v-data-table>
        </v-vlex>
        </div>
    </v-flex>
</template>

<script>
export default {
    data () {
        return {
            headers: [
                { text: 'Dessert (100g serving)', align: 'left', sortable: false, value: 'name' },
                { text: 'Calories', value: 'calories' },
                { text: 'Fat (g)', value: 'fat' },
                { text: 'Carbs (g)', value: 'carbs' },
                { text: 'Protein (g)', value: 'protein' },
                { text: 'Iron (%)', value: 'iron' }
            ],
            desserts: [
                {
                value: false,
                name: 'Frozen Yogurt',
                calories: 159,
                fat: 6.0,
                carbs: 24,
                protein: 4.0,
                iron: '1%'
                },
                {
                value: false,
                name: 'Ice cream sandwich',
                calories: 237,
                fat: 9.0,
                carbs: 37,
                protein: 4.3,
                iron: '1%'
                },
            ],
        
        }
    }
}
</script>
