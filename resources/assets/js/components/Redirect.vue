<template>
    <div @click="increment">click me {{counts}} - {{detailEtugasId}}</div>
</template>

<script>
export default {
    mounted() {
        let count = this.$store.state.count
        console.log('mounted ' + count)
    },
    
    // computed for return object to template in vuex
    computed: {
        counts() {
            return this.$store.state.count
        },
        detailEtugasId() {
            return this.$store.state.detailEtugasId
        }
    },
    methods: {
        increment() {
            this.$store.commit('increment')
        }
    }
}
</script>
