<template>
    <v-app>
	<app-layout>
		    <p class="h3">Album de Fotos</p>
			<v-divider></v-divider>
            <v-row>
                <v-col
	        v-for="album in albuns" 
    		 :key="album.id"
		cols="4"	
		  >
			<!-- Nova Interface -->
			<!-- Novo layout --> 
		
				<p class="h3"><strong>{{album.name_album}}</strong></p>
				<v-divider></v-divider>
				<v-spacer></v-spacer>
				<template>
					<v-row dense>
						<v-col
							v-for="img in images"
							:key="img"
							class="d-flex child-flex"
							cols="6"
							>
							<v-card v-if="img.id_album === album.id" class="mx-auto">			
								 <v-img
									:lazy-src="'/storage/album/'+album.name_album+'/'+img.image_name"
									:src="'/storage/album/'+album.name_album+'/'+img.image_name"
									:alt="'/storage/album/'+album.name_album+'/'+img.image_name"
									class="grey lighten-2"
									aspect-ratio="1"
									height="200px"
									@click="showImage(img)"
									contain
								>	
						                                             <template v-slot:placeholder>
						                                                    <v-row
						                                                        class="fill-height ma-0"
						                                                        align="center"
						                                                        justify="center"
						                                                    >
						                                                        <v-progress-circular
						                                                            indeterminate
						                                                            color="grey ligthen-5"
						                                                        >
						                                                            <v-responsive
															width="100%"
					                                        					v-bind:key="img.id"
														>
												
														</v-responsive>
						                                                        </v-progress-circular>
						                                                    </v-row>
                                              							  </template>
                                                					<v-card-subtitle v-text="img.image_name"></v-card-subtitle>
                                            			</v-img>
						


							</v-card>
							<v-card v-if="!images.length"">
								jojijoijs	
							</v-card>							
						</v-col>
						<v-col>
							<!-- Read more button -->
							<v-btn
								class="ma-2"
								block
								icon
								text	
								:href="`/albumImage/show/`+ album.id"
								color="deep-purple accent-4"
								v-if="images.length >= 1"
							>
									<!--	<v-icon>mdi-eye</v-icon> -->
											Read More 
							</v-btn>
						</v-col>
					</v-row>
						
				</template>
		
				
			<v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
				class="ma-2"
				color="deep-purple accent-4"	
				 icon
				>
                                

                                <v-icon
                                    class="ma-2"
                                    @click="receiveImageUpload(album)"
                                >
                                    mdi-upload
                                </v-icon> 
                                    
                            </v-btn>
                            <v-btn 
				class="ma-2"
				color="deep-purple accent-4"
                                icon
                            >
                                <v-icon
				  class="ma-2"
                                @click="receiveAlbum(album)"
				>
                                    mdi-archive-remove
                                </v-icon>
                            
                            </v-btn>
                        </v-card-actions>
                        
			<div class="text-center">
				
                         <!-- Upload Dialog -->
                 
		   <v-dialog
                        v-model="upload_dialog"
                        max-width="500px"
                    >

	                    <v-card>
	                                <v-card-title>
	                                    {{selectedAlbum.name_album}}
	                                </v-card-title>
	                                <v-card-text>
					<v-form
						ref="form_images"
						v-model="form_images"
						 @submit.prevent
					>
						Upload de Imagens
	                                    Imagem: 
	                                        <v-file-input
	                                            v-model="files"
	                                            accept="image/png image/jpg image/bmp"
	                                            show-size
	                                            label="Upload file"
	                                            filled
	                                            multiple
	                                            prepend-icon="mdi-upload"
	                                        >
	                                            <template v-slot:selection="{text}">
	                                                <v-chip
	                                                    x-small
	                                                    label
	                                                    color="primary"
	                                                >
	                                                 {{text}}	
	                                                </v-chip>
	                                            </template>
	                                        </v-file-input>
					</v-form>
	                                    
	                                </v-card-text>
	                                 <v-card-actions>
	                                    <v-btn
	                                        color="primary"
	                                        text
	                                        @click="upload(selectedAlbum)"
	                                    >
	                                       upload
	                                    </v-btn>
	                                    <v-btn
	                                        color="primary"
	                                        text
	                                        @click="upload_dialog = false"
	                                    >
	                                        close
	                                    </v-btn>
	                                   
	                                </v-card-actions>
	                            </v-card>     
	                        </v-dialog>
                    </div>    

			
			
                    <v-spacer></v-spacer>
		  	<!-- Dialog Show Image -->
		
		<v-dialog
			v-model="show_img_dialog"
			fullscreen
			tile
		>
		<!-- Toolbar para criar o header desse dialog -->
			<v-toolbar
					flat
					dark
					color="deep-purple"
				>
					<v-btn
						icon
						dark
						@click="show_img_dialog = false"
					>
						<v-icon>mdi-close</v-icon>
					</v-btn>
					<v-spacer></v-spacer>
					<v-toolbar-items>
						<v-btn
							icon
							text
							@click="remove_image_dialog = true"
						>
							<v-icon>mdi-archive-remove</v-icon>
							
					</v-btn>
					</v-toolbar-items>
				</v-toolbar>
			<!-- Exibir imagem -->
				<v-img
					:lazy-src="'/storage/album/'+album.name_album+'/'+selectedImg.image_name"
					:src="'/storage/album/'+album.name_album+'/'+selectedImg.image_name"
					:alt="'/storage/album/'+album.name_album+'/'+selectedImg.image_name"
					class="grey lighten-2"
					gradient="to bottom, rgba(0,0,0, .1), rgba(0,0,0,.5)"
					aspect-ratio="2"
					width="100%"
					contain
					
				>	
					<template v-slot:placeholder>
						                                                    <v-row
						                                                        class="fill-height ma-0"
						                                                        align="center"
						                                                        justify="center"
						                                                    >
						                                                        <v-progress-circular
						                                                            indeterminate
						                                                            color="grey ligthen-5"
						                                                        >
						                                                            <v-responsive
															width="100%"
					                                        					v-bind:key="selectedImg.id"
														>
												
														</v-responsive>
						                                                        </v-progress-circular>
						                                                    </v-row>
                                              							  </template>

					<v-card-subtitle>	{{selectedImg.image_name}}</v-card-subtitle>		
				</v-img>

		
		
		</v-dialog>

		
		<!-- Dialog Remove Image -->
                     <v-dialog
                            v-model="remove_image_dialog"
                            max-width="500px"
                        >
                            <v-card>
                                <v-card-title>
                                    {{selectedImg.image_name}}
                                </v-card-title>
                                <v-card-text>
                                    Remover Esta Imagem ?
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn
                                        color="primary"
                                        text
                                        @click="removeImage(selectedImg, album)"
                                    >
                                       remove
                                    </v-btn>
                                    <v-btn
                                        color="primary"
                                        text
                                        @click="remove_image_dialog = false"
                                    >
                                        close
                                    </v-btn>
                                   
                                </v-card-actions>
                            </v-card>
                        </v-dialog>        
						
				

                    <!-- Dialog Remove -->
                     <v-dialog
                            v-model="remove_dialog"
                            max-width="500px"
                        >
                            <v-card>
				
                                <v-card-title>
                                    {{selectedAlbum.name_album}}
                                </v-card-title>
                                <v-card-text>
                                    Remover Este Album ?
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn
                                        color="primary"
                                        text
                                        @click="removeAlbum(selectedAlbum)"
                                    >
                                       remove
                                    </v-btn>
                                    <v-btn
                                        color="primary"
                                        text
                                        @click="remove_dialog = false"
                                    >
                                        close
                                    </v-btn>
                                   
                                </v-card-actions>
                            </v-card>
                        </v-dialog>    

                    <!-- Dialog Loading Image -->
                    <v-dialog
                        v-model="loading_dialog"
                        hide-overlay
                        persistent
                        width="300"
                    >
                        <v-card
                            color="primary"
                            dark
                        >
                            <v-card-text>
                                Carregando...
                                <v-progress-linear
                                    indeterminate
                                    color="white"
                                    class="mb-0"    
                                >

                                </v-progress-linear>
                            </v-card-text>
                        </v-card>
                    </v-dialog>

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
        props: ['albuns', 'images'],
        data(){
            return {
                albuns: [],
		images: [],
                upload_dialog: false,
		show_img_dialog: false,
		remove_image_dialog: false,
                remove_dialog: false,
                loading_dialog: false,
                files: [],
		selectedAlbum: [],
		selectedImg: [],
		albumIndex: '',
		imgIndex: '',
                
            }
        },
        watch: {
            dialog(val){
                if(!val) return
                //this.loading_dialog = false;
                setTimeout(() => (this.loading_dialog = false),2000);
            },
        },
        created(){
            this.initialize();
        },
        methods: {
            initialize(){
                this.albuns = [];
		this.images = [];
            },
           /*  getItems(){
                this.$inertia.get('/album')
                .then(function(response){
                    this.albuns = response.data.items;
                    console.log(response.data.items);
                });
            }, */
	 validate(){
                    this.$refs.form_images[0].validate();
                    var data = this.$refs.form_images[0].validate();
 	        	this.$refs.form_images[0].validate();
      
                },
		receiveAlbum(album){
			this.albumIndex = this.albuns.indexOf(album);
			this.selectedAlbum = Object.assign({}, album);
			this.remove_dialog = true;	
		},
		receiveImageUpload(album){
			this.albumIndex = this.albuns.indexOf(album);
			this.selectedAlbum = Object.assign({}, album);
			this.upload_dialog = true;
		},
            upload(selectedAlbum){
		const forrmValid  = this.$refs.form_images[0].validate();
		let files = {files: this.files};
             
               // var id = album.id;
                
               this.$inertia.post(`/albumImage/upload/${selectedAlbum.id}`, files)
               .then((response) => {
                   //this.loading_dialog = false;
                   //upload_dialog = false;
                   // window.alert('upload realizado');
		//this.images.push(files);
                  window.location.reload();
                   return this.images.push(response);
                    
               })
		.catch(function(response){
                   window.alert(response);
               });
            },
	showImage(img){
		this.imgIndex = this.images.indexOf(img);
		this.selectedImg = Object.assign({}, img);
		this.show_img_dialog = true;
	},
	readMore(){
		//this.$router.push('/dashboard');
		window.alert('you click in read more button to load more image contents');
	},
	removeImage(selectedImg, selectedAlbum){
		var name_album = selectedAlbum.name_album;
		this.remove_image_dialog = false;
		axios.post(`/albumImage/remove/${selectedImg.id}`, name_album)
		.then(function(reponse){
			window.alert('Imagem removida');
			//this.images.splice(this.selectedImg, 1);
			window.location.reload();
		})
		.catch(function(response){
			window.alert(response);
		})
		
	},
            removeAlbum(selectedAlbum){
                this.$inertia.post(`/album/remove/${selectedAlbum.id}`)
                .then(function(response){
                    window.alert('Album removido');
                    window.location.reload();
                })
                .catch(function(response){
                    window.alert(response)
                });
            }
        },
	
    } 

</script>
