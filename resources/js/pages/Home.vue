<template>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Netshow.me Desafio</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1 mb-4">
                <h4 class="mb-3">Cadastro de Contato</h4>
                <form autocomplete="off" @submit.prevent="onSubmit" class="needs-validation">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Nome</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                placeholder=""
                                value=""
                                required
                                v-model="data.name"
                                :class="{'is-invalid': errors.name}"
                            >
                            <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                placeholder="email@email.com"
                                required
                                v-model="data.email"
                                :class="{'is-invalid': errors.email}"
                            >
                            <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="phone">Telefone</label>
                            <the-mask
                                type="text"
                                :mask="['(##) #####-####', '(##) ####-####']"
                                v-model="data.phone"
                                id="phone"
                                required
                                class="form-control"
                                :class="{'is-invalid': errors.phone}"
                            ></the-mask>
                            <div class="invalid-feedback" v-if="errors.phone">{{ errors.phone[0] }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="message">Mensagem</label>
                        <textarea
                            name="message"
                            id="message"
                            cols="30"
                            rows="10"
                            class="form-control"
                            required
                            v-model="data.message"
                            :class="{'is-invalid': errors.message}"
                        ></textarea>
                        <div class="invalid-feedback" v-if="errors.message">{{ errors.message[0] }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="attachment">Arquivo</label>
                        <input
                            ref="fileCreate"
                            type="file"
                            class="form-control-file"
                            id="attachment"
                            required
                            v-on:change="fileUpload()"
                            :class="{'is-invalid': errors.attachment}"
                        >
                        <div class="invalid-feedback" v-if="errors.attachment">{{ errors.attachment[0] }}</div>
                    </div>

                    <hr class="mb-4">
                    <button :disabled="loading" class="btn btn-primary btn-lg btn-block" type="submit">
                        <span v-if="loading" class="spinner-border" role="status" aria-hidden="true"></span>
                        <span v-if="loading" class="sr-only">Enviando...</span>
                        <span v-else>Cadastrar</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <h4 class="mb-3">Contatos Cadastrados</h4>
                <div class="table-responsive">
                    <p v-if="!contacts.length">Nenhum contato cadastrado</p>
                    <table v-if="contacts.length" class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Mensagem</th>
                            <th scope="col">Anexo</th>
                            <th scope="col">Data de Criação</th>
                            <th scope="col">IP</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(contact, index) in contacts" :key="index">
                            <th scope="row">{{ contact.id }}</th>
                            <td>{{ contact.name }}</td>
                            <td>{{ contact.email }}</td>
                            <td>{{ contact.phone }}</td>
                            <td>{{ contact.message }}</td>
                            <td>
                                <a :href="contact.attachment.link" target="_blank" class="btn btn-success btn-sm">Visualizar</a>
                            </td>
                            <td>{{ contact.created_at }}</td>
                            <td>{{ contact.ip }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { TheMask } from "vue-the-mask";

    export default {
        components: {
            TheMask
        },
        data() {
            return {
                data: {
                    name: null,
                    email: null,
                    phone: null,
                    message: null,
                    attachment: null
                },
                errors: {},
                contacts: [],
                loading: false
            }
        },
        mounted() {
            this.getContacts();
        },
        methods: {
            onSubmit() {
                this.loading = true;
                let formData = this.getFormData(this.data);

                axios
                    .post('contacts', formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(response => {
                        this.$toastr.s('Contato criado com sucesso', 'Sucesso')
                        this.clearForm();
                        this.getContacts();
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                        if (error.response.status === 422) {
                            this.$toastr.w(
                                "Verifique os dados preenchidos e tente novamente",
                                "Existem erros no formulário"
                            );
                            this.errors = error.response.data.errors || {};
                        }

                        if (error.response.status === 500) {
                            this.$toastr.e(
                                "Caso o problema persista entre em contato com o Administrador",
                                "Erro ao tentar cadastrar um contato"
                            );
                        }
                    });
            },
            getContacts() {
                axios.get('contacts').then(response => {
                    this.contacts = response.data;
                }).catch(err => {
                    this.$toastr.e("Caso o problema persista entre em contato com o Administrador",
                        "Erro ao tentar resgatar os contatos");
                });
            },
            getFormData(data) {
                var formData = new FormData();
                if (data instanceof Object) {
                    Object.keys(data).forEach(key => {
                        const value = data[key];
                        if (Array.isArray(value)) {
                            if (value.length > 0) {
                                value.forEach(val => {
                                    formData.append(`${key}[]`, val);
                                });
                            } else {
                                formData.append(`${key}`, []);
                            }
                        } else {
                            formData.append(key, value);
                        }
                    });
                }
                return formData;
            },
            fileUpload() {
                this.data.attachment = this.$refs.fileCreate.files[0]
            },
            clearForm() {
                this.$refs.fileCreate.value = '';
                Object.assign(this.$data, this.$options.data());
            },
        }
    }
</script>
