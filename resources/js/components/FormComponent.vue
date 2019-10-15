<template>
    <div>
        <b-form @keydown="onKeyDown">
            <b-row>
                <b-col>
                    <h1 v-if="! caseId">Add case</h1>
                    <h1 v-else>
                        Edit case #{{ caseId }}
                    </h1>
                </b-col>
                <b-col class="text-right">
                    <b-button variant="success" @click="onSubmit"><i class="far fa-save"></i> Save</b-button>
                    <b-button v-if="caseId" @click="onDelete" variant="danger"><i class="far fa-trash-alt"></i></b-button>
                </b-col>
            </b-row>

            <b-form-group label="Upload photos" label-size="lg">
                <b-form-file
                    v-model="form.images"
                    :state="Boolean(form.images)"
                    multiple
                    accept="image/jpeg, image/png, image/gif"
                    placeholder="Choose a photo or drop it here..."
                    drop-placeholder="Drop file here..."
                ></b-form-file>
            </b-form-group>
            <transition name="fade">
                <b-form-group label="Photos preview" v-if="photoPreview.length > 0">
                    <b-img v-for="(photo, index) in photoPreview" :key="`key-${index}`" :src="photo"
                           @click.prevent="onPhotoDelete(index)" v-b-tooltip.bottom.hover title="Click to remove"
                           thumbnail style="max-width: 150px; max-height: 150px;" class="mr-3"></b-img>
                </b-form-group>
            </transition>
            <b-form-group v-if="caseId" label="Uploaded photos" label-size="lg">
                <span v-if="form.images.length === 0">No photos uploaded</span>
            </b-form-group>

            <b-form-group label="Common information" label-size="lg">
                <b-form-group label="Type">
                    <b-form-radio-group
                        v-model="form.properties.type"
                        :options="caseTypes"
                    ></b-form-radio-group>
                </b-form-group>
                <b-form-row>
                    <b-col>
                        <b-form-group label="Title">
                            <b-input v-model="form.title" trim :state="isValid('title')"
                                     placeholder="Case name"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('title') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Link">
                            <b-input v-model="form.link" trim :state="isValid('link')"
                                     placeholder="Link to the product page on the manufacturer’s website"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('link') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Price">
                            <b-input v-model="form.price" type="number" :state="isValid('price')"
                                     placeholder="Case price, 199.99"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('price') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <b-form-group label="Description">
                    <b-textarea v-model="form.description" rows="3" max-rows="15" trim :state="isValid('description')"
                                placeholder="Some notes about the case"></b-textarea>
                    <b-form-invalid-feedback>
                        {{ validationMessage('description') }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form-group>

            <b-form-group label="Size" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Length, mm">
                            <b-input v-model="form.properties.size.length" type="number"
                                     :state="isValid('properties.size.length')"
                                     placeholder="Case length"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.length') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Width, mm">
                            <b-input v-model="form.properties.size.width" type="number"
                                     :state="isValid('properties.size.length')"
                                     placeholder="Case width"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.length') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Height, mm">
                            <b-input v-model="form.properties.size.height" type="number"
                                     :state="isValid('properties.size.height')"
                                     placeholder="Case height"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.height') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="Volume, mm">
                            <b-input v-model="form.properties.size.volume" type="number"
                                     :state="isValid('properties.size.volume')"
                                     placeholder="Case volume"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.size.volume') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-form-row>
            </b-form-group>

            <b-form-group label="CPU & GPU" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="CPU max cooler height, mm">
                            <b-input v-model="form.properties.cpu.max_height" type="number"
                                     :state="isValid('properties.cpu.max_height')"
                                     placeholder="Case height"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.cpu.max_height') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="GPU max length, mm">
                            <b-input v-model="form.properties.gpu.length" type="number"
                                     :state="isValid('properties.gpu.length')"
                                     placeholder="GPU max length"></b-input>
                            <b-form-invalid-feedback>
                                {{ validationMessage('properties.gpu.length') }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="GPU slots">
                            <b-input v-model="form.properties.gpu.slots" type="number"
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

            <b-form-group label="PSU" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Type">
                            <b-form-checkbox-group
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
                            <b-input v-model="form.properties.psu.max_length" type="number"
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

            <b-form-group label="Storage" label-size="lg">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Number of HDD">
                            <b-input v-model="form.properties.storage.hdd" type="number"
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
                            <b-input v-model="form.properties.storage.ssd" type="number"
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

            <b-form-group label="Fans & Water Cooling">
                <b-form-row>
                    <b-col>
                        <b-form-group label="Front">
                            <b-input v-model="form.properties.fans.front" type="number"
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
                            <b-input v-model="form.properties.fans.top" type="number"
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
                            <b-input v-model="form.properties.fans.bottom" type="number"
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
                            <b-input v-model="form.properties.fans.rear" type="number"
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
                            <b-input v-model="form.properties.fans.side" type="number"
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
                <b-button variant="success" @click="onSubmit"><i class="far fa-save"></i> Save</b-button>
                <b-button v-if="caseId" @click="onDelete" variant="danger"><i class="far fa-trash-alt"></i></b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
    import Form from 'form-backend-validation';
    export default {
        props: {
          caseId: {
              type: Number,
              default: null,
          },
        },
        data() {
            return {
                caseId: null,
                photoPreview: [],
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
                    images: [],
                    title: null,
                    link: null,
                    price: null,
                    description: null,
                    properties: {
                        type: 'mini_itx',
                        size: {
                            length: null,
                            height: null,
                            width: null,
                            volume: null
                        },
                        cpu: {
                            max_height: null,
                        },
                        gpu: {
                            length: null,
                            slots: null,
                        },
                        psu: {
                            type: [],
                            max_length: null,
                        },
                        storage: {
                            hdd: null,
                            ssd: null
                        },
                        fans: {
                            front: null,
                            top: null,
                            bottom: null,
                            rear: null,
                            side: null
                        }
                    }
                }),
            }
        },
        mounted() {

        },

        methods: {
            onKeyDown(event) {
                //console.log(event.target);
                //this.form.errors.clear(event.target.name);
            },
            onSubmit() {
                this.form.post('/cases');
            },
            onReset() {
                alert('reset');
            },
            onPhotoDelete(index){
                this.form.images.splice(index, 1);
            },
            isValid(field) {
                return this.form.hasError(field) ? false : null;
            },
            validationMessage(field) {
                if (! this.form.hasError(field)) {
                    return false;
                }
                return this.form.getError(field);
            }
        },
        watch: {
            "form.images": function (newValue, oldValue) {
                const newPreviews = [];

                newValue.forEach((photo) => {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        newPreviews.push(e.target.result);
                    };
                    reader.readAsDataURL(photo);
                });

                this.photoPreview = newPreviews;
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
