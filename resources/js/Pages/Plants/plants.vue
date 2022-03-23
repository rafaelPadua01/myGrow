<template>
	<v-app> 
	<app-layout>
		  
        <p>Plantas Salvas </p>
	<v-divider></v-divider>
	<v-row justify='center'>
		<v-col>
		<!-- Dialog 0f insert plant -->
			
			<v-dialog
				v-model="insert_dialog"
				max-width="600px"
			>
				<!-- Botão v-dialog form insert plant -->
				<template v-slot:activator="{on, attrs}">
					<v-btn
					class="ma-2"
					outlined
					color="deep-purple accent-4"
					icon	
					@click="insert_form(items)"
					>	
						<v-icon>mdi-pencil</v-icon>
						Nova Planta
					</v-btn>
				</template>
				<v-card>
					<v-card-title>
						<span class="text-h5"Insert Plant</span>
					</v-card-title>
					<v-card-text>
						<v-container>
							<v-form
								ref="form_plant"
								v-model="valid_plant"
								lazy-validation
								@submit.prevent
							>
								<v-row>
									<v-col 
										 cols="12"
                								sm="6"
               									 md="4"
									>
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
									</v-col>
									<v-col
										cols="12"
                								sm="6"
               									 md="4"
									>
										 <v-select
							                    v-model="select"
							                    :items="items_especie"
							                    :rules="[v => !!v || 'item is required']"
							                    label="espécie"
							                    required
							                    >
							                    Image:
							                  </v-select>
									</v-col>
								</v-row>
								<v-row>
									<v-col
										cols="12"
                								sm="6"
               									 md="4"
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
									</v-col>
									<v-col
									cols="12"
                								sm="6"
               									 md="4"
                							>
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
									</v-col>
								</v-row>
								
							</v-form>
							
							
				 					
		
						
						</v-container>
					</v-card-text>

					<v-card-actions>
						 <!-- Botões de função dos forms -->
				                <v-btn
				                    :disabled="!valid"
				                    class="mr-4"
				                    @click="save()"
							text
						>
				                    
				                    salvar    
				
				                </v-btn>
						<v-btn
				               		text
				                    class="mr-4"
				                    @click="reset()">
				                    Reset Form    
				                </v-btn>
				                <v-btn
				                    color="warning"
				                    class="mr-4"
				                    onClick="resetValidation()">
				                    Reset Validation  
				
				                </v-btn>
						 <v-btn
				                    :disabled="!valid"
				                    text
				                    class="mr-4"
				                    @click="insert_dialog = false"
							text
							icon
						>
				                    <v-icon>mdi-close</v-icon>
				              			Close
				
				                </v-btn>
					</v-card-actions>
				</v-card>
				</v-dialog>
		</v-col>
	</v-row>
            <v-row>
                <v-col 
                    v-for="item in items" 
                    :key='item'
	>
                    <v-card
                        elevation="2"
                        class='mx-auto'
                        max-width="400"
                        outlined
                        tile
                   >
                    <v-card-title>
				{{item.name}}
			</v-card-title>
                    <v-divider></v-divider>
                     <!-- Carrega a imagem de perfil -->
			<div
				v-for="profile_img in image_profile"
				:key="profile_img.id"
			>
				<div v-if="profile_img.id_plant === item.id">
					<v-img
						:src="'storage/profile_plant/'+profile_img.name_image"
						:alt="profile_img.name_image"
					>
					 <v-card-subtitle class="text-primary">
		                           <div>Data de Germinação: {{item.germinacao}} </div>
		                           <div>Data de Floração: {{item.floracao}}</div>
                       			</v-card-subtitle>
				</v-img>
				</div>
				</div>
			 <v-divider></v-divider>
                      
                        <!-- menu de opções do card -->
                        <v-card-actions>
                            <v-menu
                                offset-y
                            >
                                <template v-slot:activator="{attrs, on}">
                                    <!-- botão que recebe as funções do menu -->
                                    <v-btn
                                        color="deep-purple accent--4"
                                        text
                                        class="white--text ma-5"
                                        v-bind="attrs"
                                        v-on="on"
                                    >
                                        Opções
                                    </v-btn>
                                </template>
                                <!-- itens do menu -->
                                <v-list>
                                    <!-- profile Plant -->
                                    <v-list-item>
                                        <v-list-item-title>
                                            <div class="text-center">
						
                                                <v-dialog
                                                    v-model="profile_dialog"
                                                    width="500"
                                                >   
                                                    <template v-slot:activator="{on, attrs}"> 
                                                        <v-btn 
                                                            color="primary"
                                                            text
								v-on="on"
								v-bind="attrs"
                                                         @click="received_profile_img(image_profile)"
                                                        >
                                                            Ver perfil
                                                        </v-btn>
                                                    </template>
                                                        <v-card>
                                                            <v-card-title class="text-h5 grey lighten-2">
                                                                {{item.name}}
                                                            </v-card-title>
								<!-- imagem da planta -->
								<v-card-subtitle>
									
								<v-col >
								<div  v-if="selectedImage" >
									<div 
										v-for="img in selectedImage"
										 v-bind:key="img.id"
									>
										
								 <template  v-if="img.id_plant === item.id">
                                                                        <v-card
										class="mx-4"
                                                                            max-width="100"
                                                                            outlined
                                                                            color="primary"
                                                                        >
                                                                      
                                                                            <v-img
                                                                                :src="'storage/profile_plant/' + img.name_image"
                                                                                :alt="img.name_image"
                                                                                max-height="150" 
                                                                                max-width="150"
                                                                        >

                                                                            </v-img>
                                                                      

                                                                        <v-card-actions>
                                                                        <v-divider></v-divider>
                                                                        <v-btn
                                                                                outlined
                                                                                rounded
                                                                                text
                                                                                @click="dialog_profileRemove = true"
                                                                            >
                                                                                Remover
                                                                            </v-btn>
                                                                            <!--
                                                                            <v-btn
                                                                                outlined
                                                                                rounded
                                                                                text
                                                                                @click="removeProfileImage(img)"
                                                                            >
                                                                                Remover
                                                                            </v-btn> -->
                                                                        </v-card-actions>   
                                                                        </v-card>
                                                                        <!-- Alert remove Profile image plant		-->
									<div
										class="text-center"
									>
										<v-dialog
											v-model="dialog_profileRemove"
											width="500"
											>
											<v-card>
							                        <v-card-title class="text-h5 grey lighten-2">
											Remover imagem de Perfil
										</v-card-title>
										<v-card-text>Você tem certeza que quer Remover a Imagem ???</v-card-text>
							                        
										<v-divider></v-divider>
										
										<v-card-actions class="justify-right">
							                            <v-btn
							                                outlined
							                                text
							                                @click="removeProfileImage(img)"
							                            >
											Remover
										</v-btn>
										<v-btn
											outlined
											text
											@click="dialog_profileRemove = false"
											>
												Fechar
											</v-btn>
							                        </v-card-actions>
												</v-card>
											</v-dialog>
									</div>
									
									  </template>
									
								</div>
						             </div>
						
							<template v-show="img.id_plant != item.id	">
								  <div>
										<!-- Entrada de Imagem da Planta -->
	                                                                        <v-file-input
	                                                                            counter
	                                                                            show-size
	                                                                            small-chips
	                                                                            truncate="50"
	                                                                            v-model="files"
	                                                                            accept="image/png, image/jpeg, image/bmp"
	                                                                            placeholder="fotos da planta"
	                                                                            prepend-icon="mdi-camera"
	                                                                        
	                                                                        
	                                                                        >
	                                                                            Imagem da Planta:
	                                                                        </v-file-input>    
	                                                                        <v-col>
	                                                                        <v-btn
	                                                                            text
	                                                                            @click="uploadProfileImg(item)"
	                                                                        >
	                                                                            Upload image
	                                                                        </v-btn>
	                                                                     </v-col>
	                                                                    </div>
                                                                    </template>  
                                                                  </v-col>
							</v-card-subtitle>
                                                        
                                                            <v-card-text>
								<v-col>
									  <v-divider></v-divider>
                                                                Nome: {{item.name}} id: {{item.id}}
                                                                <v-divider></v-divider>
                                                                germinacao: {{item.germinacao}}
								
								<v-divider></v-divider>
								 floracao: {{item.floracao}}
                                                            
								</v-col>
  								<!-- datas de criação e atualização -->
								<v-divider></v-divider>
                                                                <v-col>
                                                                       
		                                                                Criado em: {{item.created_at}} Atualizado em: {{item.update_at}}
                                                       		     
                                                                </v-col>
                                                                
                                                              </v-card-text>
                                                                   
                                                              

                                                            <v-card-actions class="justify-end">
                                                                <v-btn
                                                                    text
                                                                    @click="profile_dialog = false"
                                                                >
                                                                    Fechar
                                                                </v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    
                                                </v-dialog>
                                            </div>
                                           
                                </v-list-item-title>
                                    </v-list-item>

                                    <!-- Atualizar perfil -->
                                    <v-list-item>
                                        <v-list-item-title>
                                        <div class="text-center">
                                            <v-dialog 
                                                v-model="edit_dialog"
                                                width="500"
                                            >
                                                <template v-slot:activator="{on, attrs}">
                                                <v-btn
                                                color="primary"
                                                text
                                                v-bind="attrs"
                                                v-on="on"
                                                >
                                                Atualizar
                                            </v-btn>
                                            </template>
                                            <v-card>
                                                <v-card-title class="text-h5 grey lighten-2">
                                                    Editar {{item.name}} {{item.id}}
                                                </v-card-title>

                                                <v-card-text>
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
                                                                :placeholder="item.name"
                                                                required

                                                            >
                                                            Nome: 
                                                            </v-text-field>

                                                        
                                                        </v-row>
                                                        <v-row>
                                                            <!--
                                                            <div v-for="p_img in image_profile" :key="p_img.id">
                                                            
                                                            <p v-if="p_img.id_plant === item.id">
                                                                {{p_img.id}}
                                                            </p>
                                                             Entrada de Imagem da Planta 
                                                            <v-file-input
                                                                counter
                                                                multiple
                                                                show-size
                                                                small-chips
                                                                truncate="50"
                                                                v-model="files"
								ref="files"
                                                                accept="image/png, image/jpeg, image/bmp"
                                                                placeholder="fotos da planta"
                                                                prepend-icon="mdi-camera"
                                                                v-else
                                                            
                                                            >
                                                                Imagem da Planta:
                                                            </v-file-input>    
                                                           
                                                            </div>
                                                            -->
                                                           

                                                        </v-row>    
                                                    

                                                            <!-- Entrada de Especie da planta -->
                                                            <v-row>
                                                                <v-select
                                                                v-model="select"
                                                                :items="items_select"
                                                                :rules="[v => !!v || 'item is required']"
                                                                label="especie"
                                                                :placeholder="item.especie"
                                                                required
                                                                >
                                                                Image:
                                                            </v-select>
                                                            </v-row>
                                                        

                                                        

                                                            <!-- entradas de datas Germinação e Floração estimados -->
                                                            <v-row>
                                                            Data de Germinação:
                                                                <v-date-picker
                                                                    label="Data de Germinaçao"
                                                                    width="290"
                                                                    v-model="dateGerm"
                                                                    :allowed-dates="allowedDates"
                                                                    :placeholder="item.germinacao"
                                                                    class="mt-4"
                                                                    min="2016-06-15"
                                                                    max="2050-06-14"
                                                                >
                                                                    
                                                                </v-date-picker>    
                                                                Data da Germinação: {{item.germinacao}}
                                                            </v-row>
                                                            <v-row>
                                                                Data de Floração: 
                                                                <v-date-picker
                                                                    label="Data de Floração"
                                                                    width="290"
                                                                    v-model="dateFlora"
                                                                    :allowed-dates="allowedDates"
                                                                    :placeholder="item.floracao"
                                                                    class="mt-4"
                                                                    min="2016-06-15"
                                                                    max="2050-06-14"
                                                                    >
                                                                    
                                                                    
                                                                </v-date-picker> 

                                                                Data da Floração: {{item.flora}}
                                                            </v-row>

                                                            <!-- Botões de função dos forms -->
                                                            <v-btn
                                                                :disabled="!valid"
                                                                color="success"
                                                                class="mr-4"
                                                                @click="edit(item)"
                                                            >
                                                                
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
                                                </v-card-text>
                                            </v-card>
                                            </v-dialog>
                                           
                                        </div>
                                            
                                            
                                        </v-list-item-title>
                                    </v-list-item>

                                    <!-- Criar album -->
                                    <v-list-item>
                                        <v-list-item-title>
                                            <div class="text-center">
                                                <v-dialog
                                                    v-model="album_dialog"
                                                    width="500"
                                                >
                                                    <template v-slot:activator="{on,attrs}">
                                                        <v-btn
                                                            color="primary"
                                                            text
                                                            v-bind="attrs"
                                                            v-on="on"
                                                        >
                                                            Criar Album
                                                        </v-btn>
							
                                                    </template>
                                                     <v-card>
                                                    <v-card-title>Cria um novo Album</v-card-title>
							<v-divider></v-divider>
                                                    
							<v-card-text>
                                                        Crie um album e acompanhe o desenvolvimento de sua queridinha...
                                                        <v-form ref="album_form" v-model="album_form" @submit.prevent>
                                                            <v-container>
                                                                <v-row>
                                                                    <v-col
                                                                        cols="12"
                                                                        md="6"
                                                                    >
                                                                        <v-text-field
                                                                            v-model="album_name"
                                                                            :rules="album_nameRules"
                                                                            :counter="4"
									
                                                                            label="Nome para o seu album"
                                                                            required
                                                                        >
										{{item.name}}
                                                                        </v-text-field>    
                                                                    </v-col>
                                                                </v-row>
                                                            </v-container>
                                                        </v-form>
                                                    </v-card-text>
						<v-divider></v-divider>
                                                    <v-card-actions>
                                                        <v-btn
                                                            text
							color="deep-purple accent-4"
                                                            @click="createAlbum(item)"
                                                        >
                                                            Salvar
                                                        </v-btn>
                                                        <v-btn
                                                            text
								color="deep-purple accent-4"
                                                            @click="dialog = false"
                                                        >
                                                            Fechar
                                                        </v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                                </v-dialog>
                                                

                                               
                                            </div>
                                            

                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                            
                            <!-- Botão Remover -->
                            <div class='text-center'>
                                <!-- modal de confirmação de remoção -->
                                <v-dialog
                                    v-model="dialog"
                                    width="500"
                                >
                                    <template v-slot:activator="{on, attrs}">
                                        <v-btn
                                            color="deep-purple accent-4 "
                                            text
                                            v-bind="attrs"
                                            v-on="on"
					@click="received_plant(item)"
                                        >
                                            Remover
                                        </v-btn>
                                      </template>
                                        <v-card>
                                            <v-card-title 
                                                class="text-h5 grey lighten-2"
                                            >
                                                Remover {{selected_plant.name}}
                                            </v-card-title>

                                            <v-card-text>
                                                Você tem certeza que desaja remover está planta ???
                                            </v-card-text>

                                            <v-divider></v-divider>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="primary"
                                                    text
                                                    @click="remove(selected_plant)"
                                                >
                                                    Remover
                                                </v-btn>
						 <v-btn
                                                    color="primary"
                                                    text
                                                    @click="dialog = false"
                                                >
                                                	Fechar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                  
                                </v-dialog>
                            </div>
                            
                        </v-card-actions>
                        
                    </v-card>
		   </v-col>
            </v-row>
	</app-layout>
    
    </v-app>

</template>


<script>
 	import AppLayout from '@/Layouts/AppLayout'

    export default{
	components: {
		AppLayout,	
	},
        props: ['items', 'image_profile'],
        data(){
            return{
                value: true,
		value_plant: true,
		 valid: true,
		valid_plant: true,
                items: [],
                image_profile: [],
		selectedImage: [],
		profileImgIndex: '',
		insert_dialog: false,
                dialog: false,
                profile_dialog: false,
		dialog_profileRemove: false,
                edit_dialog: false,
                album_dialog: false,
                card_edit: true,
                album_form: true, 
                album_name: '',
                files: '',
		 name: '',
          	  nameRules: [
		                v => !!v || 'Name is required',
		                v => (v && v.length <= 100) || 'Name must be less than 4 characters',
            ],
                album_nameRules: [
                    v => !!v || 'Um nome é necessário', 
                    v => v.length <= 10 || 'O nome deve ser maior que 4 caractéres' 
                ], 
           
            name: '',
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 100) || 'Name must be less than 4 characters',
            ],
            image_profile_rules: [
                value => !value || value.size <= 1000000 || 'Profile image shold be less than 10Mb', 
            ],
            
            url: null,
            select: null,
		 items_especie: [
                'preensed',
                'skank',
                'Indica',
                'Sativa',
                'Hibrida',
            ],
            items_select: [
                'preensed',
                'skank',
                'Indica',
                'Sativa',
                'Hibrida',
            ],
            dateGerm: '2022-03-02',
            dateFlora: '2022-03-02',
            selected_plant: [],
		plantIndex: '' 
            }
        },
        created(){
            this.initialize();
        },
        methods: {
            initialize(){
                this.items = [];
                this.image_profile = [];
            },
	
            validate(){
                    this.$refs.form[0].validate();
                    var data = this.$refs.form[0].validate();
 	        	this.$refs.album_form[0].validate();
                var data = this.$refs.album_form[0].validate();
                    //console.log(this.$refs.form[0]);
                	//    edit(data);
                },
	  validate_plant(){
	                    this.$refs.form_plant.validate();
	                    var data = this.$refs.form_plant.validate();
	                    save(data);
                },
		insert_form(items){
		this.selectedndex = this.items.indexOf(items);
		this.selectedItem = Object.assign({}, items);
		this.insert_dialog = true;
	},
/*
            validateAlbum(){
                this.$refs.album_form[0].validate();
                var data = this.$refs.album_form[0].validate();
                createAlbum(data);
            },
*/
		reset(){
                    this.$refs.form_plant[0].reset()
                },
                resetValidation(){
                    this.$refs.form_plant[0].resetValidation()
                },
	//Function save Datas
	  save(){
	
	                   const formValid = this.$refs.form_plant.validate();
	                   let data = {name: this.name, especie: this.select, germinacao: this.dateGerm, floracao: this.dateFlora};
	                   if(formValid){
	                      axios.post('formPlant/save', data)
	                    .then((response) => {
				this.insert_dialog = false;
				return this.items.push(response.data);
	                     })
	                    .catch((response) => {
	                        window.alert(response);
	                    });
	                   }
                },
            edit(item){
                const formValid = this.$refs.form[0].validate();
                var item_update_id = item.id;
               // window.alert(item_update);
                let data = {
                        name: this.name,
                         especie: this.select,
                        germinacao: this.dateGerm, 
                        floracao: this.dateFlora
                    };  
                if(formValid){
                    this.edit_dialog = true;

                 axios.post(`/plant/edit/${item_update_id}`, data)
                    .then((response) => {
                      this.edit_dialog = false;
			return this.items.push(response.data);
			window.location.reload();
                    })
                    .catch((response) => {
                       window.alert(response);
                    });
                   
                }
            },
	//recebe os parametros da planta
	received_plant(item){
		this.plantIndex = this.items.indexOf(item);
		this.selected_plant = Object.assign({}, item);
		this.dialog = true;	
	}, 
	//Recebe as profiles images
	received_profile_img(image_profile){
		this.profile_imgIndex = this.image_profile.indexOf(image_profile.id);
		this.selectedImage = Object.assign({}, image_profile);
		this.profile_dialog = true;
	},
	//Remove a planta selecionada
            remove(selected_plant){
                axios.post(`/plant/remove/${selected_plant.id}`)
                .then((response) => {
                   // window.alert('Planta removida');
			this.dialog = false;
                   return this.items.splice(this.plantIndex, 1);
             })
                .catch((response) => {
			if(error.response.data)
			{
				window.alert('Erro: ' + error.response.data);
			}
			else{
					window.alert(response);
			}		
		});
            },
	
            uploadProfileImg(item){

              let data_file = {files: this.files};
		
             this.$inertia.post(`/img_profile/${item.id}`, data_file)
                .then((response) => {
                    
		return this.image_profile.push(response.data);
			//window.location.reload();
			//console.log(data_profile_img);
                    
                })
                .catch((response) => {
                    window.alert(erro.response);
			
                });

            },
            removeProfileImage(img)
            {
                axios.delete(`/img_profile/remove/${img.id}`, img)
                .then((response) => {
                	this.dialogProfile_remove = false;
			this.dialog = false;
			return this.image_profile.splice(response.data, 1);
			
                })
                .catch(function(response){
                    window.alert(response);
                })
            },
            createAlbum(item){
                const formValid = this.$refs.album_form[0].validate();
                let data = {album_name: this.album_name};
                this.$inertia.post(`/album/create/${item.id}`, data)
                .then(function(response){
                    window.alert(`Novo album criado`);

                    //return;
                })
                .catch(function(response){
                    window.alert(response);
                });

            },
		   allowedDates:
                    val => parseInt(val.split('-')[2], 10) % 2 == 0,
        },
        mounted(){
          // this.getItems();

        }
    }
</script>