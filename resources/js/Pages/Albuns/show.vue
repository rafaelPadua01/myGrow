<template>
	<v-app>
		<app-layout>
		<p class="h2"><strong>Images</strong></p>	
		<v-divider></v-divider>
		<v-spacer></v-spacer>
			<v-row>
			<v-col>
				<v-divider></v-divider>
				<v-spacer></v-spacer>
				<template>
					<v-row dense>
						<v-col 
							v-for="img in images"
							v-bind:key="img"
							class="d-flex child-flex"
						>
							<!-- Card of images -->
							<v-card class="mx-auto"> 
								<v-card-title>{{img.image_name}}</v-card-title>
								<v-card-subtitle><small>Album: {{album.name_album}}</small></v-card-subtitle>
								<v-card-subtitle><small>Upload: {{img.created_at}}</small></v-card-subtitle>
								<v-card-text>
									<v-img
									:lazy-src="`/storage/album/` + album.name_album + '/'  + img.image_name"
									:src="`storage/album/` + album.name_album + '/'  + img.image_name "
									:alt="`storage/album/` + album.name_album + '/'  + img.image_name + '.' + 'img.image_extension'"
									class="grey ligthen-2"
									aspect-ratio="1'"
									height="200px"
									contain
									@click="dialog_galery(img)"
									>
									
								</v-img>
								</v-card-text>
								<v-card-actions>
									<v-btn
										class="mr-2"
										color="deep-purple accent-4"
										text
										icon
										@click="dialog_remove(img)"
									>
										<v-icon>mdi-remove</v-icon>
										Remove
									</v-btn>
								</v-card-actions>
							</v-card>
					<!-- Galery Dialog -->
					<v-dialog
						v-model="galery"
						transition="dialog-top-transition"
					>
					
						<v-card>
							<v-toolbar
								dark
								color="deep-purple accent-4">
								<v-btn
									icon
									dark
									@click="galery = false"s
								>
									<v-icon>mdi-close</v-icon>
								</v-btn>
								<v-card-title>Galery Images</v-card-title>	
						</v-toolbar>
							
							<v-card-text>
								<v-carousel>
									<v-carousel-item
										v-for="img_galery in images"
										v-bind:key="img_galery"
										:lazy-src="'/storage/album/'+ album.name_album + '/' + img_galery.image_name"
										:src="'/storage/album/'+ album.name_album + '/' + img_galery.image_name"
										class="grey ligthen-2"
										aspect-ratio="1'"
										reverse-transition="fade-trasition"
										transition="fade-transition"
										eager
										width="200rem"
				
										>
											
										{{album.name_album}} /  {{img.image_name}}
									</v-carousel-item>
									
								</v-carousel>
							</v-card-text>
							
						</v-card>	
					</v-dialog>
				
						<!-- Remove Dialog -->
							<v-dialog
								v-model="remove_dialog"
								max-width="500px" 
							>
								<v-card>
									<v-card-title>{{img_selected.image_name}}</v-card-title>
									<v-card-text>
										Remove this image ? 
									</v-card-text>
									<v-card-actions>
										<v-btn
											color="deep-purple accent-4"
											text
											icon
											@click="remove_image(img_selected)"
										>
											<v-icon>mdi-remove</v-icon>
												Remover 		
										</v-btn>
										
									</v-card-actions>
								</v-card>
							</v-dialog>
						</v-col>
					</v-row>
				</template>
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
	props: ['images', 'album'],
	data(){
		return {
			images: [],
			album: [],
			remove_dialog: false,
			img_selected: [],
			imgIndex: '',
			galery: false,
			model: 0,
		}
	},
	methods: {
		initialize(){
			this.images = [];
			this.albuns = [];	
		},
		dialog_remove(img){
			//this.imgIndex = this.images.indexOf(img)
			this.img_selected = Object.assign({}, img); 
			this.remove_dialog = true;
		},
		dialog_galery(img){
			this.imgIndex =  this.images.indexOf(img);
			this.img_selected = Object.assign({}, img);
			this.galery = true;
		},
		remove_image(img_selected)
		{
			
			axios.post(`/albumImage/remove/${this.img_selected.id}`, this.img_selected.id)
			.then((response) => {
				this.remove_dialog = false;
				this.images.splice(this.img_selected, 1);
			})
			.catch((response) => {
				window.alert('Error' + error.response);
			});	
		},
		
	},
	created(){
		this.initialize();
		}
	}
</script>