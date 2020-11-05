<template>
    <div>
        <section class="auth">
            <div class="auth__main">
                <div>
                    <img class="auth__logo" src="/images/logo.png" alt="Volution" title="Volution">

                    <form class="auth__form">
                        <label class="auth__label auth__label--error" v-if="this.error">Please check your username and password. If you still can't log in, contact your Volution administrator.</label>

                        <div class="auth__element">
                            <label class="auth__label">Username</label>
                            <input class="auth__input" type="text" v-model="email" autocomplete="off" autofocus>
                        </div>

                        <div class="auth__element">
                            <label class="auth__label">Password</label>
                            <input class="auth__input" type="password" v-model="password">
                        </div>

                        <div class="auth__element">
                            <button type="button" class="auth__button" @click="this.login">Log In</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="auth__side">
                <div>
                    <time>Tuesday, 30th October, 2020 | 9:30 AM BST</time>
                    <h2><span>< </span>JOIN OUR WEBINAR<span> ></span></h2>
                    <p>Join this learning event showcasing the UK and Ireland’s top Trailblazers and how they are future proofing their organisations</p>
                    <a href="#none">Register Now</a>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data () {
            return {
                email: '',
                password: '',
                error: false
            };
        },

        mounted() {
        },

        methods: {
            login() {
                axios.post('/api/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {

                    if (response.data.passed) {

                        this.error = false;
                        localStorage.setItem('usertoken', response.data.user.api_token);

                        window.location.href = '/';

                    } else {

                        this.error = true;
                        localStorage.removeItem('usertoken');

                    }

                })
                .catch(error => {

                    console.log('ERROR');
                    console.log(error)

                })
                .finally(() => this.loading = false);
            }
        }
    };
</script>
