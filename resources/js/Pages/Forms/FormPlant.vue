<template>
    <v-app>
        <v-container>
            <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            @submit.prevent
            >
            <v-row>
                <!-- Entrada de nome das Plantas -->
                <v-text-field
                    v-model='name'
                    :counter='4'
                    :rules='nameRules'
                    label='Nome da planta'
                    required

                >
                Nome: 
                </v-text-field>

               
            </v-row>
            <v-row>
                  <!-- Entrada de Imagem da Planta 
                <v-file-input
                    counter
                    multiple
                    show-size
                    small-chips
                    truncate="50"
                    v-model="imagePlant"
                    accept="image/png, image/jpeg, image/bmp"
                    placeholder="fotos da planta"
                    prepend-icon="mdi-camera"
                   
                >
                    Imagem da Planta:
                </v-file-input>    
             -->

            </v-row>    
          

                <!-- Entrada de Especie da planta -->
                <v-row>
                    <v-select
                    v-model="select"
                    :items="items"
                    :rules="[v => !!v || 'item is required']"
                    label="espécie"
                    required
                    >
                    Image:
                  </v-select>
                </v-row>
               

              

                <!-- entradas de datas Germinação e Floração estimados -->
                <v-row 
                    
                >
                Data de Germinação:
                    <v-date-picker
                        label="Data de Germinaçao"
                        width="290"
                        v-model="dateGerm"
                        :allowed-dates="allowedDates"
                        class="mt-4"
                        min="2016-06-15"
                        max="2050-06-14"
                       >
                        
                    </v-date-picker>    
                    Data da Germinação: {{dateGerm}}
                </v-row>
                <v-row>
                    Data de Floração: 
                    <v-date-picker
                        label="Data de Floração"
                        width="290"
                        v-model="dateFlora"
                        :allowed-dates="allowedDates"
                        class="mt-4"
                        min="2016-06-15"
                        max="2050-06-14"
                        >
                        
                        
                    </v-date-picker> 

                    Data da Floração: {{dateFlora}}
                </v-row>

                <!-- Botões de função dos forms -->
                <v-btn
                    :disabled="!valid"
                    color="success"
                    class="mr-4"
                    @click="save()">
                    
                    salvar    

                </v-btn>


                <v-btn
                    color="error"
                    class="mr-4"
                    @click="reset">
                    Reset Form    
                </v-btn>
                <v-btn
                    color="warning"
                    class="mr-4"
                    @click="resetValidation">
                    Reset Validation  

                </v-btn>

                
            </v-form>
        </v-container>
        
       
    </v-app>
</template>

<script>
export default{
    data(){
        return {
            valid: true,
            name: '',
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 100) || 'Name must be less than 4 characters',
            ],
            
            url: null,
            //imagePlant: [],
            select: null,
            items: [
                'preensed',
                'skank',
                'Indica',
                'Sativa',
                'Hibrida',
            ],
            dateGerm: '2022-03-02',
            dateFlora: '2022-03-02',
            
        
        }

    },
    methods:{
                validate(){
                    this.$refs.form.validate();
                    var data = this.$refs.form.validate();
                    save(data);
                },
                reset(){
                    this.$refs.form.reset()
                },
                resetValidation(){
                    this.$refs.form.resetValidation()
                },
                save(){

                   const formValid = this.$refs.form.validate();
                   let data = {name: this.name, especie: this.select, germinacao: this.dateGerm, floracao: this.dateFlora};
                   if(formValid){
                       
                    this.$inertia.post('formPlant/save', data)
                    .then(function(response){
                        window.alert('Nova Planta salva no banco de dados...');
                     //   window.location.href="/" 
                    })
                    .catch(function(response){
                        window.alert(response);
                    });
                   }
                   
                  

                },
                allowedDates:
                    val => parseInt(val.split('-')[2], 10) % 2 == 0,
                

                
            },
}
</script>
