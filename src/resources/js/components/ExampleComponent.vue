
<template>
    <div class="container" :id="id">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        Good morning {{ name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true,
                default: 'Anonymous'
            },
            id: {
                type: String,
                required: true
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
