<template>
    <div>{{count}}</div>
</template>

<script>
export default {
    mounted() {
        let count = this.$store.state.count
        console.log('mounted ' + count)
    },
    
    computed: {
        count() {
            return this.$store.state.count
        }
    }
}
</script>
