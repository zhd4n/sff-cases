<template>
    <div>
        <b-form @keydown="onKeyDown">
            <b-row>
                <b-col>
                    <h1 v-if="! this.case">Add case</h1>
                    <h1 v-else>
                        Edit case #{{ this.case.id }}
                    </h1>
                </b-col>
                <b-col class="text-right">
                    <b-button :disabled="loading" @click="onSubmit" variant="success"><i class="far fa-save"></i> Save</b-button>
                    <b-button :disabled="loading" v-if="this.case" @click="onDelete" variant="danger"><i class="far fa-trash-alt"></i>
                    </b-button>
                </b-col>
            </b-row>

            <b-form-group label="Upload photos" label-size="lg" :disabled="loading">
                <b-form-file
                    name="upload"
                    v-model="form.upload"
                    :state="isValid('upload')"
                    multiple
                    accept="image/jpeg, image/png, image/gif"
                    placeholder="Choose a photo or drop it here..."
                    drop-placeholder="Drop file here..."
                ></b-form-file>
            </b-form-group>
            <transition name="fade">
                <b-form-group label="Photos preview" v-if="uploadPreview.length > 0">
                    <b-img v-for="(photo, index) in uploadPreview" :key="`key-${index}`" :src="photo"
                           @click.prevent="onPhotoDelete(index)" v-b-tooltip.bottom.hover title="Click to remove"
                           thumbnail style="max-width: 150px; max-height: 150px;" class="mr-3">
                    </b-img>
                </b-form-group>
            </transition>

            <b-form-group v-if="this.case" label="Uploaded photos" label-size="lg">
                <span v-if="form.gallery.length === 0">No photos uploaded</span>
                <b-img v-for="(photo, index) in form.gallery" :key="`key-${index}`" :src="photo.url"
                       @click.prevent="onGalleryDelete(index)"
                       v-b-tooltip.bottom.hover title="Click to remove"
                       thumbnail style="max-width: 150px; max-height: 150px;" class="mr-3">
                </b-img>
            </b-form-group>


            <b-form-group label="Common information" :disabled="loading" label-size="lg">
                <b-form-group label="Type">
                    <b-form-radio-group
                        name="properties[type]"
                        v-model="form.properties.type"
                        :options="caseTypes"
                        :state="isValid('properties.type')"
                    ></b-form-radio-group>
                    <b-form-invalid-feedback>
                        {{ validationMessage('properties.type') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-row>
                    <b-col>
                        <b-form-group label="Title">
                            <b-input name="title" v-model="form.title" trim :state="isValid('title')"
                                     placeholder="Case name"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('title') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Link">
                            <b-input name="link" v-model="form.link" trim :state="isValid('link')"
                                     placeholder="Link to the product page on the manufacturer’s website"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('link') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Price">
                            <b-input name="price" v-model="form.price" type="number" :state="isValid('price')"
                                     placeholder="Case price, 199.99"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('price') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <b-form-group label="Description">
                    <b-textarea name="description" v-model="form.description" rows="3" max-rows="15" trim :state="isValid('description')"
                                placeholder="Some notes about the case"></b-textarea>
                    <b-form-invalid-feedback>
                        {{ validationMessage('description') }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form-group>

            <b-form-group label="Size" :disabled="loading" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Length, mm">
                            <b-input name="properties[size][length]"
                                     v-model="form.properties.size.length" type="number"
                                     :state="isValid('properties.size.length')"
                                     placeholder="Case length"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.length') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Width, mm">
                            <b-input name="properties[size][width]"
                                     v-model="form.properties.size.width" type="number"
                                     :state="isValid('properties.size.length')"
                                     placeholder="Case width"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.length') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Height, mm">
                            <b-input name="properties[size][height]"
                                     v-model="form.properties.size.height" type="number"
                                     :state="isValid('properties.size.height')"
                                     placeholder="Case height"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.height') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Volume, mm">
                            <b-input name="properties[size][volume]"
                                     v-model="form.properties.size.volume" type="number"
                                     :state="isValid('properties.size.volume')"
                                     placeholder="Case volume"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.volume') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
            </b-form-group>

            <b-form-group label="CPU & GPU" :disabled="loading" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="CPU max cooler height, mm">
                            <b-input name="properties[cpu][max_height]"
                                     v-model="form.properties.cpu.max_height" type="number"
                                     :state="isValid('properties.cpu.max_height')"
                                     placeholder="Case height"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.cpu.max_height') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="GPU max length, mm">
                            <b-input name="properties[gpu][length]"
                                     v-model="form.properties.gpu.length" type="number"
                                     :state="isValid('properties.gpu.length')"
                                     placeholder="GPU max length"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.gpu.length') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="GPU slots">
                            <b-input name="properties[gpu][slots]"
                                     v-model="form.properties.gpu.slots" type="number"
                                     :state="isValid('properties.gpu.slots')"
                                     placeholder="Max GPU height">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.gpu.slots') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
            </b-form-group>

            <b-form-group label="PSU" :disabled="loading" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Type">
                            <b-form-checkbox-group
                                name="properties[psu][type][]"
                                :options="psuTypes"
                                v-model="form.properties.psu.type"
                                :state="isValid('properties.psu.type')"
                            ></b-form-checkbox-group>
                            <b-form-invalid-feedback :state="isValid('properties.psu.type')">
                                {{ validationMessage('properties.psu.type') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Max length, mm">
                            <b-input name="properties[psu][max_length]"
                                     v-model="form.properties.psu.max_length" type="number"
                                     :state="isValid('properties.psu.max_length')"
                                     placeholder="Max PSU height">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.psu.max_length') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
            </b-form-group>

            <b-form-group label="Storage" :disabled="loading" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Number of HDD">
                            <b-input name="properties[storage][hdd]"
                                     v-model="form.properties.storage.hdd" type="number"
                                     :state="isValid('properties.state.hdd')"
                                     placeholder="Number of HDD">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.state.hdd') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Number of SSD">
                            <b-input name="properties[storage][ssd]"
                                     v-model="form.properties.storage.ssd" type="number"
                                     :state="isValid('properties.state.ssd')"
                                     placeholder="Number of SSD">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.state.ssd') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
            </b-form-group>

            <b-form-group label="Fans & Water Cooling" :disabled="loading">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Front">
                            <b-input name="properties[fans][front]"
                                     v-model="form.properties.fans.front" type="number"
                                     :state="isValid('properties.fans.front')"
                                     placeholder="Number of coolers in front">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.fans.front') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Top">
                            <b-input name="properties[fans][top]"
                                     v-model="form.properties.fans.top" type="number"
                                     :state="isValid('properties.fans.top')"
                                     placeholder="Number of coolers in top">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.fans.top') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Bottom">
                            <b-input name="properties[fans][bottom]"
                                     v-model="form.properties.fans.bottom" type="number"
                                     :state="isValid('properties.fans.bottom')"
                                     placeholder="Number of coolers in bottom">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.fans.bottom') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Rear">
                            <b-input name="properties[fans][rear]"
                                     v-model="form.properties.fans.rear" type="number"
                                     :state="isValid('properties.fans.rear')"
                                     placeholder="Number of coolers in rear">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.fans.rear') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Side">
                            <b-input name="properties[fans][side]"
                                     v-model="form.properties.fans.side" type="number"
                                     :state="isValid('properties.fans.side')"
                                     placeholder="Number of coolers in side">
                            </b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.fans.side') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
            </b-form-group>

            <div class="text-right">
                <b-button variant="success" :disabled="loading" @click="onSubmit"><i class="far fa-save"></i> Save</b-button>
                <b-button v-if="this.case" :disabled="loading" @click="onDelete" variant="danger"><i class="far fa-trash-alt"></i></b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
    import Form from 'form-backend-validation';

    export default {
        props: {
            case: {
                default: null,
            },
            errors: {
                default: null,
            }
        },
        data() {
            return {
                loading: false,
                uploadPreview: [],
                caseTypes: [
                    {text: 'Mini-ITX', value: 'mini_itx'},
                    {text: 'Micro-ATX', value: 'micro_atx'},
                    {text: 'ATX', value: 'atx'}
                ],
                psuTypes: [
                    {text: 'ATX', value: 'atx'},
                    {text: 'SFX', value: 'sfx'},
                    {text: 'SFX-L', value: 'sfx_l'},
                    {text: 'FlexATX', value: 'flex_atx'},
                    {text: 'DC-ATX Pico', value: 'dc_atx'},
                ],
                form: new Form({
                    _method: null,
                    gallery: [],
                    upload: [],
                    title: '',
                    link: '',
                    price: '',
                    description: '',
                    properties: {
                        type: 'mini_itx',
                        size: {
                            length: '',
                            height: '',
                            width: '',
                            volume: ''
                        },
                        cpu: {
                            max_height: '',
                        },
                        gpu: {
                            max_length: '',
                            slots: '',
                        },
                        psu: {
                            type: [],
                            max_length: '',
                        },
                        storage: {
                            hdd: '',
                            ssd: ''
                        },
                        fans: {
                            front: '',
                            top: '',
                            bottom: '',
                            rear: '',
                            side: ''
                        }
                    }
                }),
            }
        },

        async mounted() {
            this.loading = true;

            if (this.case) {
                this.form.populate(this.case);
            }

            this.loading = false;
        },

        methods: {
            onKeyDown(event) {
                //console.log(event.target);
                //this.form.errors.clear(event.target.name);
            },

            async onSubmit() {
                try {
                    this.loading = true;
                    const response = await (this.case === null ? this.store() : this.update());
                    if (typeof response.redirect !== 'undefined') {
                        window.location = response.redirect;
                    } else {
                        this.$successMsg('Data successfully saved');
                    }
                    this.loading = false;
                } catch (e) {
                    if (typeof e.response.status !== 'undefined' && e.response.status === 422) {
                        this.$errorMsg('Validation error, please check the form');
                    }
                    this.loading = false;
                }
            },

            async store() {
                return await this.form.post('/cases');
            },

            async update() {
                this.form.populate({_method: 'PUT'});
                return await this.form.post(`/cases/${this.case.id}`);
            },

            async onDelete() {
                this.loading = true;
                try {
                    const response = await this.form.delete(`/cases/${this.case.id}`);
                    if (typeof response.redirect !== 'undefined') {
                        window.location = response.redirect;
                    } else {
                        this.$successMsg('Data successfully deleted');
                    }
                    this.loading = false;
                } catch (e) {
                    this.$errorMsg('Error deleting data');
                    console.log(e);
                    this.loading = false;
                }
            },


            onPhotoDelete(index) {
                if (! this.loading) {
                    this.form.upload.splice(index, 1);
                }
            },

            onGalleryDelete(index) {
                if (! this.loading) {
                    this.form.gallery.splice(index, 1);
                }
            },

            isValid(field) {
                return this.form.hasError(field) ? false : null;
            },

            validationMessage(field) {
                if (!this.form.hasError(field)) {
                    return false;
                }
                return this.form.getError(field);
            },
        },
        watch: {
            "form.upload": function (newValue, oldValue) {
                const newPreviews = [];

                newValue.forEach((photo) => {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        newPreviews.push(e.target.result);
                    };
                    reader.readAsDataURL(photo);
                });

                this.uploadPreview = newPreviews;
            }
        },
    }
</script>
<style>
    .fade-enter-active, .fade-leave-active {
        /*transition: opacity .001s;*/
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
