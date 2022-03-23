<template>
	<v-app>
		<div>	
			<v-app-bar
					color="deep-purple accent-6"
					dense
					dark
				>
				 	 <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
					
					<v-toolbar-title>
						<v-icon color="green">
							mdi-cannabis
						</v-icon>	
						MyGrow
					</v-toolbar-title>

					<v-spacer></v-spacer>

					<v-btn icon>
						<v-icon>mdi-magnify</v-icon>
					</v-btn>
					
					<v-btn icon>
						<v-icon>mdi-heart</v-icon>
					</v-btn>

					<v-menu
						left
						bottom
					>
						<template v-slot:activator="{on, attrs}">
							<v-btn
								icon
								v-bind="attrs"
								v-on="on"
							>
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</template>
						<v-list>
							<v-list-item>
								<v-list-item-title>Opção 1</v-list-item-title>
							</v-list-item>
						</v-list>
					</v-menu>
			</v-app-bar>

			 <v-navigation-drawer
				class="deep-purple text--white accent-6"
			      v-model="drawer"
			      absolute
			      bottom
			      temporary
				dark
				app
			    >
				<v-spacer></v-spacer>
				<template v-slot:prepend>
					
					<div v-for="user in users" v-bind:key="user.id">
						<v-list-item v-if="!user.id">
						<v-list-item-content two-line>
							<v-list-item-title>
								você não está autenticado ainda...
								
							</v-list-item-title>
							<v-list-item-subtitle>
								<v-btn
									outlined
									icon
									text
									href="/login"
								>
									<v-icon>mdi-login-variant</v-icon>
									Entrar 
								</v-btn>
							</v-list-item-subtitle>
							<v-divider></v-divider>
						</v-list-item-content>	
					</v-list-item>
							<!-- verify if user have a profile pic (verifica se usuario possui uma imagem de perfil) --> 
					<v-list-item two-line
						 v-else-if="user && !user.profile_photo_path || user.profile_photo_path === 'NULL' || user.profile_photo_path === ' '"
					>
							<v-list-item-avatar>
								<v-avatar color="indigo">
									<v-icon dark @click="user_photo_profile()">
										mdi-account-circle
									</v-icon>
								</v-avatar>
								
							</v-list-item-avatar>
							
							<v-list-item-content>
								<v-list-item-title>{{ user.name }}</v-list-item-title>
								<v-list-item-subtitle> <small>Logged in {{user.email}}</small></v-list-item-subtitle>
								<v-divider></v-divider>
								
							</v-list-item-content>
						</v-list-item>	
		
						<!-- else user logged in show profile photo -->
						<v-list-item two-line v-else-if="user && user.profile_photo_path">
							
							<v-list-item-avatar>
								<v-avatar color="indigo">
									<v-img
									:src="'/storage/'+`${user.profile_photo_path}`"
									alt="'${user.profile_photo_url}'"
									aspect-ratio="1"
								>
									<v-btn 
										text
										@click="receive_profile_photo(user)"	
										icon
									>
											<v-icon>mdi-remove</v-icon>
											<small>Remover</small>
										</v-btn>	
									</v-img>
								</v-avatar>
								
							</v-list-item-avatar>
								<v-list-item-content>
									<v-list-item-title>{{ user.name }}</v-list-item-title>
									<v-list-item-subtitle> <small>Logged in {{user.email}}</small></v-list-item-subtitle>
									<v-divider></v-divider>
								</v-list-item-content>
					</v-list-item>
					</div>
				</template>
					<!-- Dialog to Upload profile pic -->	
						<template>
								<v-dialog
								v-model="dialog_profile_pic"
								transition="dialog-bottom-transition"
								>
								<v-card>
									<v-card-title>Upload Profile Picture</v-card-title>
									<v-divider></v-divider>
									<v-card-subtitle>Select your profile picture </v-card-subtitle>
									<v-card-text>
										
										<v-file-input
											v-model="files"
											accept="image/png, image/jpeg"
											label="click to select any image "
											placeholder="select an image to profile"
											show-size
											multiple
											prepend-icon="mdi-upload"
										>
										
										</v-file-input>
											
									</v-card-text>

									<v-card-actions>
										<v-btn
											@click="dialog_profile_pic = false"
											outlined
											text
										>
											Close(fechar)
										</v-btn>
										<v-btn
											text
											outlined
											@click="user_photo_upload()">
											upload
										</v-btn>
									</v-card-actions>
									
								</v-card>
							</v-dialog>
						</template>

					<!-- Dialog remove Profile photo -->
					<template>	
						<v-dialog
							v-model="dialog_remove_profile_photo"
							max-width="500px"
						>
							<v-card>
								<v-card-title>{{selectedUserImg.profile_photo_url}}</v-card-title>
								 <v-card-text>
										you shure that remove this profile photo ???
										
								</v-card-text>
								 
								<v-card-actions>
									<v-btn
										class="mx-4"
										icon
										text
										@click="dialog_remove_profile_photo = false"
									>
										<v-icon>mdi-close</v-icon>
											Close
									</v-btn>
									<v-btn
										class="mx-4"
										icon
										text
										@click="remove_profile_photo(selectedUserImg)"
									>
									<v-icon>mdi-remove</v-icon>
										Remove
								</v-btn>
								</v-card-actions>
							</v-card>
						</v-dialog>
					</template>
				
				<v-divider></v-divider>

			      <v-list
			        nav
			        dense
			      >
			        <v-list-item-group
			          v-model="group"
			          active-class="deep-purple--text text--accent-8"
			        >
			          <v-list-item>
					<v-btn 
						text
						icon
						href="/dashboard">
					<v-list-item-icon>
					<v-icon>mdi-view-dashboard-outline</v-icon>
					</v-list-item-icon>
			            <v-list-item-title>
					Dashboard
					</v-list-item-title>
				</v-btn>
			          </v-list-item>

				<v-divider></v-divider>
				<!-- Link for profile datas -->
				<v-list-item>
					<v-btn
						text
						icon
						href="#"
					>
						<v-list-item-icon>
							<v-icon>mdi-account-details</v-icon>
						</v-list-item-icon>
							<v-list-item-title>
								Profile
							</v-list-item-title>
						
					</v-btn>
				</v-list-item>

				<v-divider></v-divider>
				<!-- Link for plants -->
			          <v-list-item>
					<v-btn
						text
						icon
						href="/plant"				
					>
					<v-list-item-icon>
						<v-icon>mdi-cannabis</v-icon>
					</v-list-item-icon>
				            	<v-list-item-title> 
							Plants
						</v-list-item-title>
				</v-btn>
			          </v-list-item>
				<v-divider></v-divider>		
			        
				  <v-list-item>
					<v-btn
						icon
						href="/album"
					>
						<v-list-item-icon>
							<v-icon>mdi-folder</v-icon>
						</v-list-item-icon>
				        	    <v-list-item-title>
						
						Albuns
						</v-list-item-title>
					</v-btn>

			          </v-list-item>
				<v-divider></v-divider>
			          <v-list-item>
			            <v-list-item-title>Buzz</v-list-item-title>
			          </v-list-item>
			        </v-list-item-group>
			      </v-list>
			<!-- Logout button -->
				<template v-slot:append	>
					<div class="pa-2">
						<v-btn
							text
							icon
							@click="logout()"
						>
							<v-icon>mdi-logout-variant</v-icon>Logout
						</v-btn>
					</div>
				</template>
			    </v-navigation-drawer>

				<!-- main content -->
				<v-main>
					<v-container fluid>
						<slot></slot>
					</v-container>
					
				</v-main>

				<v-spacer>.</v-spacer>
				<!-- Footer -->


				<template>
					<v-footer
					bottom
					dark
					inset
					padless
					
				>
					<v-card
						class='flex'
						flat
						tile
						color="deep-purple accent-6"
					>
						<v-card-title class="deep-purple">
							<strong class="subheading">Get connected with us on social networks</strong>
		
							<v-spacer></v-spacer>
							
							<v-btn
								class="mx-4"
								dark
								icon
							>
								<v-icon>mdi-facebook</v-icon>
							</v-btn>
							<v-btn
								class="mx-4"
								dark
								icon
							>
								<v-icon>mdi-linkedin</v-icon>
							</v-btn>
							<v-btn
								class="mx-4"
								dark
								icon
							>
								<v-icon>mdi-instagram</v-icon>
							</v-btn>
						</v-card-title>
						<v-divider></v-divider>
						<v-card-text class="py-2 white--text text-center">
							{{new Date().getFullYear() }} - <strong> Vuetify </strong>
						</v-card-text>
					</v-card>	
				</v-footer>

				</template>
			
							
			</div>
				
	</v-app>
</template>


<script>
	  export default {
	
	    data: () => ({
	      drawer: false,
	      group: null,
		users: [],
		dialog_profile_pic: false,
		dialog_remove_profile_photo: false,
		files: '',
		src_profile_img: [],
		selectedUserImg: [],
		userIndex: '', 
	    }
),
	
	    watch: {
	      group () {
	        this.drawer = false
	      },
		
	    },
	
	methods: {
		initialize(){
		this.users = [];
	
	},
	getUsers(){
			axios.get('/users')
			.then((response) => {
				//console.log(response.data);
				//this.users = response.data;
				return this.users.push(response.data);
				//console.log(this.users);
				
			})
			.catch(function(response){
				window.alert('Você está acessando uma página restrita, faça login ou caia fora... ' + response.error);
			});
	},
	user_photo_profile(user){
		this.userIndex = this.users.indexOf(user);
		this.selectedUserImg = Object.assign({} , this.user);
		this.dialog_profile_pic = true;
		//window.alert('Insert profile avatar, this is not may ...');
	},
	user_photo_upload(){
		let data_file = {files: this.files};
		
		axios.post('/upload_profile_photo', data_file)	
		.then((response) => {
		console.log(data_file);
			this.dialog_profile_pic = false;
			return this.users.push(response.data);
		})
		.catch((response) => {
			console.log(response);
		});
	}, 
	receive_profile_photo(user){
		this.userIndex = this.users.indexOf(user);
		this.selectedUserImg  = Object.assign({}, user);
		this.dialog_remove_profile_photo = true;
	},	
	remove_profile_photo(selectedUserImg){
		axios.post('/delete_profile_image', this.selectedUserImg)
		.then((response) => {
			//window.alert(response);
			//window.location.reload();
			return this.users.profile_photo_path.split("" );	
		
		})
		.catch((response) => {
		 	console.log(response);
	});
		//window.alert( 'remove this photo ? ');
	},
		logout(){
			axios.post('/logout')
			.then(function(response){
				window.alert('Logout realizado com sucesso');
				window.location.reload();
			})
			.catch(function(response){
				window.alert(response);
			});
		},
	
	},
		created(){
			this.initialize();	
			this.getUsers();
		}	
  }
</script>
