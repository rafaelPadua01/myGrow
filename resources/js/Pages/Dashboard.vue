<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
	<div class="py-12">
		  
                		<p class="h2">MyGrow System, welcome<strong> {{users.name}} </strong></p> 
					<v-divider></v-divider>  
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
				
				<v-item-group active-class="primary">
					<v-container>	
						<v-row>
							<v-col 
								cols="12"
								md="4"
							>
								<v-item v-slot="{active, toggle}">
									<v-card
										:color="active ? 'primary'  : '' 	"
										class="d-flex align-center"
										dark
										height="200"
										@click="toggle"
							
									>
										<v-img
											src="layout/Dashboard/gps-brasilia-mostra-tendencias-de-plantas-para-a-primavera.jpg"
											class="text--white  align-top"
											gradient="to bottom, rgb(0, 0,  0, .1), rgb(0, 0, 0,  .5)"
											height="200px"
											opacity="0.8"
										>
											<v-card-title>Plants</v-card-title>

												<v-card-subtitle>Clique para ver as informações</v-card-subtitle>
												<v-divider></v-divider>
												<v-scroll-y-transition>
													<div
														 v-if="active"
														class="text-h3  text--white flex-grow-1 text-center"
													>
													<v-card-text>
														<p> Quantidade de plantas: ({{quantidade}}) </p>
													</v-card-text>
														
															
													</div>
												</v-scroll-y-transition>
										</v-img>
										
									</v-card>
							
								</v-item>
							
							
							</v-col>
							
							<v-col 
								cols="12"
								md="4"
							>
								<v-item v-slot="{active, toggle}">
									<v-card
										:color="active ? 'primary'  : '' 	"
										class="text--whte d-flex align-center"
										dark
										height="200"
										@click="toggle"
										
									>	
										<v-img
											src="layout/Dashboard/albuns2.jpeg"
											class="text--white  align-top"
											gradient="to bottom, rgb(0, 0,  0, .1), rgb(0, 0, 0,  .5)"
											height="200px"
											opacity="0.8"
										>
											<v-card-title>Albuns</v-card-title>
											<v-card-subtitle>Clique para ver as informações</v-card-subtitle>
											<v-divider></v-divider>
											<v-scroll-y-transition>
												<div
													 v-if="active"
													class="text-h3 flex-grow-1 text-center"
												>
													<v-card-text>
														Albuns: {{qtd_albuns}}
													</v-card-text:>
												</div>
										</v-scroll-y-transition>
										</v-img>
										
									</v-card>
							
								</v-item>
							
							
							</v-col>
							
							
							<v-col 
								cols="12"
								md="4"
							>
								<v-item v-slot="{active, toggle}">
									<v-card
										:color="active ? 'success'  : '' 	"
										class="d-flex align-center"
										dark
										height="200"
										@click="toggle"
							
									>	
										<v-img
											src="layout/Dashboard/download.jpeg"
											class="text--white  align-top"
											gradient="to bottom, rgb(0, 0,  0, .1), rgb(0, 0, 0,  .5)"
											height="200px"
											opacity="0.8"
										>
											<v-card-title>Watcher</v-card-title>
										<v-card-subtitle>Clique para ver a hora</v-card-subtitle>
										<v-divider></v-divider>
										<v-scroll-y-transition>
											<div
												 v-if="active"
												class="text-h4 flex-grow-1 text-center"
											>
												<v-card-text>{{time_current}}</v-card-text>
													
											</div>
										</v-scroll-y-transition>
										</v-img>
										
									</v-card>
							
								</v-item>
							
							
							</v-col>
						</v-row>
						<v-row>
							<v-col
								cols="12"
								md="4"
							>
								<v-item v-slot="{active, toggle}">
									<v-card
										:color="active ? 'success'  : '' 	"
										class="d-flex align-center"
										dark
										height="200"
										@click="toggle"
									>
										
										
													
														<v-img
															src="layout/Dashboard/veg.jpg"
															class="text--white  align-top"
															gradient="to bottom, rgb(0, 0,  0, .1), rgb(0, 0, 0,  .5)"
															height="200px"
															opacity="0.8"
														>
															<v-card-title>Vegetativo</v-card-title>
															<v-card-subtitle>Clique para ver</v-card-subtitle>
															<v-divider></v-divider>
																<v-scroll-y-transition>
																<div
																	v-if="active"
																	class="text-h5 flex-grow-1 text-center"
																>
															<v-card-text v-for="(plant, key) in plants" v-bind:key="plant.id">
															 <p v-if="plant.germinacao <=  Date()">
																Plantas em vegetação: qtd ({{++key}})
															</p>
														</v-card-text>
													</div>
													</v-scroll-y-transition>
													</v-img>
										</v-card>
								</v-item>
							</v-col>
						
							<v-col
								cols="12"
								md="4"
							>
								<v-item v-slot="{active, toggle}">
									<v-card
										:color="active ? 'success'  : '' 	"
										class="d-flex align-center"
										dark
										height="200"
										@click="toggle"
									>
									
										<v-img
											src="layout/Dashboard/planta-sombras.jpg"
											class="text--white  align-top"
											gradient="to bottom, rgb(0, 0,  0, .1), rgb(0, 0, 0,  .5)"
											height="200px"
											opacity="0.8"
										>
											<v-card-title>Floração</v-card-title>
											<v-card-subtitle>Clique para ver</v-card-subtitle>
											<v-divider></v-divider>
											<v-scroll-y-transition>
													<div
														v-if="active"
														class="text-h5 flex-grow-1 text-center"
													>
														<v-card-text v-for="(plant, key) in plants" v-bind:key="plant.id">
															 <p v-if="plant.floracao >=  Date() || plant.flora <= Date()">
																Plantas em vegetação: qtd ({{++key}})
															</p>
															 <p v-else>
																Plantas em Floração: qtd (0)
															</p>
														</v-card-text>
													</div>
												
											</v-scroll-y-transition>
										</v-img>
										</v-card>
								</v-item>
							</v-col>
							<v-col>
								<v-card
								 class="mx-auto "
								max-width="400"
								v-for="w in weather"
								v-bind:key="w.id"
							>
							<!--	<v-card-title>Weather</v-card-title> -->
							<!--	<v-card-subtitle></v-card-subtitle>
								<v-divider></v-divider> -->
				
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title class="text-h6">
												{{w.city}}
												
											</v-list-item-title>
											<v-list-item-subtitle>
												{{w.date}}, {{w.description}}
											</v-list-item-subtitle>
										
										</v-list-item-content>
									</v-list-item>
				
									<v-divider></v-divider>
								<v-card-text>
									<v-row align="center">
										<v-col
											class="text-h3"
											cols="6"
										>
											{{w.temp}}&deg:C
										</v-col>
										<v-col cols="6">
											
											<v-img
												src="https://cdn.	vuetifyjs.com/images/cards/sun.png"
												alt="Image do sol"
												width="92"
											></v-img>
										</v-col>
									</v-row>
								</v-card-text>
								
								<v-list-item>
									<v-list-item-icon>
										<v-icon>mdi-send</v-icon>
									</v-list-item-icon>			
									<v-list-item-subtitle>{{w.wind_speedy}} </v-list-item-subtitle>
								</v-list-item>
							
								<v-list-item>
									<v-list-item-icon>
										<v-icon>mdi-cloud-download</v-icon>
									</v-list-item-icon>
			
									<v-list-item-subtitle>{{w.humidity}}%</v-list-item-subtitle>
								</v-list-item>
							<!--	<v-slider
									v-model="time"
									:max="6"
									:tick-labels="labels"
									class="mx-4"
									ticks
								>
								</v-slider>
								
								<v-list class="transparent">
									<v-list-item
										v-for="fore in forecast"
										:key="fore.day"
								>
									<v-list-item-title>{{fore.day}}</v-list-item-title>		
									<v-list-item-icon>
										<v-icon>{{fore.icon}}</v-icon>
									</v-list-item-icon>
									</v-list-item>
									<v-list-subtitle>
										{{fore.temp}}
									</v-list-subtitle>
								</v-list>
					
								<v-divider></v-divider>
			
								<v-card-actions></v-card-actions>
								-->
						</v-card>	
							</v-col>
						</v-row>
					</v-container>
				</v-item-group>
				
			</div>
			
		</div>
	
     
	
	</div>
		
		
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
	props: ['users'],
	data: () => ({
	
				time_current: '',
				plants: [],
				count_vega: '',
				flora: '',
				albuns: [],
				weather: [],
				quantidade : '',
				qtd_albuns: '',
				labels: ['SU', 'MD', 'TU', 'WED', 'TH', 'FR', 'SA'],
				time: 0,
				fore: '',
				forecast: [
					{ day: 'Tuesday' , icon: 'mdi-white-balance-sunny', temp:  '24\x80/12/\x80'  },
					{ day: 'Wednesday', icon: 'mdi-white-balance-sunny', temp: '22\x80/14\x80' },
					{ day: 'thursday', icon: 'mdi-cloud', temp: '25\zx80/15\x80' },
				],
			}
	),
	methods: {
		getTimeZone(){
			var time_zone = new Date().toString() //.match(/([A-Z]+[\+--][0-9]+.*)/)[1];
			return this.time_current  =  time_zone; 
		},
		//Recebe os dados das plantas e armazena via push em uma variavel
		getPlants(){
			var count = 0;
			axios.get('/api/plants')
			.then((response) => {
				this.plants = response.data;
				for( var i = 0; i <= this.plants.length;  i++){
					count += i;
					this.quantidade = count; 
						
				}
				console.log('contagem de plantas : ' +  count);
				return count;
			}).
			catch((response) => {	
				window.alert(response);
			});
		},
		getAlbuns(){
			var count = 0;
			axios.get('/api/albuns')
			.then((response) => {
				this.albuns = response.data; 
				for(var i = 0; i <= this.albuns.length; i++) {
					count += i;
					this.qtd_albuns = count; 
				}
			//	console.log('contagem de albuns:' + count);
				return this.qtd_albuns;
			})
			.catch((response) => {
				window.alert(response);
				return false;
			});
		},
		getWeather(){
		axios.get('https://api.hgbrasil.com/weather?format=json-cors&key=3fdd062b&user_ip=remote')
		.then((response) => {
			//this.wheather = response.data;
			const received_data = response.data.results;
			return this.weather.push(received_data); 
		})
		.catch((response) => {
			window.alert(response);
		});
	},
	},
	created(){
		this.getTimeZone();	
		this.getPlants();		
		this.getAlbuns();
		this.getWeather();
		
	}

    }
</script>
