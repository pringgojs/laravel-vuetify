<template>
    <div></div>
</template>


<script>
import Cookies from 'js-cookie'
export default {
    created () {
        if(!Cookies.get('user')) {
            this.$router.push('/login')
        }
        this.$store.state.user = JSON.parse(Cookies.get('user'))

    }    
}
</script>
