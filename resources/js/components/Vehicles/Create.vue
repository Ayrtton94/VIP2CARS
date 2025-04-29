<template>
  <div class="container mt-5">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white">
        <h1 class="h3 mb-0">Registrar Vehículo y Contacto</h1>
      </div>
      
      <div class="card-body">
        <form @submit.prevent="guardarDatos">
          <!-- Datos del Vehículo -->
          <div class="mb-5">
            <h2 class="h4 mb-4 border-bottom pb-2">
              <i class="fas fa-car me-2"></i>Datos del Vehículo
            </h2>
            
            <div class="row g-3">
              <div class="col-md-6">
                <label for="plate" class="form-label">Placa</label>
                <input v-model="vehiculo.plate" type="text" id="plate" class="form-control" placeholder="ABC-123">
              </div>
              
              <div class="col-md-6">
                <label for="brand" class="form-label">Marca</label>
                <input v-model="vehiculo.brand" type="text" id="brand" class="form-control" placeholder="Toyota">
              </div>
              
              <div class="col-md-6">
                <label for="model" class="form-label">Modelo</label>
                <input v-model="vehiculo.model" type="text" id="model" class="form-control" placeholder="Corolla">
              </div>
              
              <div class="col-md-6">
                <label for="year" class="form-label">Año de fabricación</label>
                <input v-model="vehiculo.manufacturing_year" type="text" id="year" class="form-control" placeholder="2020">
              </div>
            </div>
          </div>
          
          <!-- Datos del Contacto -->
          <div class="mb-5">
            <h2 class="h4 mb-4 border-bottom pb-2">
              <i class="fas fa-user me-2"></i>Datos del Contacto
            </h2>
            
            <div class="row g-3">
              <div class="col-md-6">
                <label for="firstName" class="form-label">Nombre</label>
                <input v-model="contacto.first_name" type="text" id="firstName" class="form-control" placeholder="Juan">
              </div>
              
              <div class="col-md-6">
                <label for="lastName" class="form-label">Apellido</label>
                <input v-model="contacto.last_name" type="text" id="lastName" class="form-control" placeholder="Pérez">
              </div>
              
              <div class="col-md-6">
                <label for="document" class="form-label">Número de documento</label>
                <input v-model="contacto.document_number" type="text" id="document" class="form-control" placeholder="12345678">
              </div>
              
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input v-model="contacto.email" type="email" id="email" class="form-control" placeholder="juan@example.com">
              </div>
              
              <div class="col-md-6">
                <label for="phone" class="form-label">Teléfono</label>
                <input v-model="contacto.phone" type="text" id="phone" class="form-control" placeholder="+51 987654321">
              </div>
            </div>
          </div>
          
          <!-- Botones -->
          <div class="d-flex justify-content-between mt-4">
            <button type="button" @click="regreso" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Regresar
            </button>
            
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-2"></i>Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
  data() {
    return {
      vehiculo: {
        plate: '',
        brand: '',
        model: '',
        manufacturing_year: '',
      },
      contacto: {
        first_name: '',
        last_name: '',
        document_number: '',
        email: '',
        phone: '',
      },
    };
  },
  methods: {
    regreso() {
      window.location.href = '/vehicles'; 
    },
    async guardarDatos() {
      try {
        const payload = {
          ...this.vehiculo,
          ...this.contacto,
        };

        const response = await axios.post('/vehicles', payload);

        Swal.fire({
          icon: 'success',
          title: '¡Guardado!',
          text: response.data.message,
          showConfirmButton: false,
          timer: 2000
        });

        // Reseteamos los campos
        this.vehiculo = { plate: '', brand: '', model: '', manufacturing_year: '' };
        this.contacto = { first_name: '', last_name: '', document_number: '', email: '', phone: '' };

      } catch (error) {
        if (error.response && error.response.data.errors) {
          let mensajes = Object.values(error.response.data.errors).flat().join('<br>');
          Swal.fire({
            icon: 'error',
            title: 'Errores de validación',
            html: mensajes,
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Algo salió mal. Por favor intente nuevamente.',
          });
        }
      }
    },
  },
};
</script>

<style scoped>
.card {
  border-radius: 10px;
  overflow: hidden;
}

.form-control:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn {
  padding: 0.5rem 1.5rem;
  font-weight: 500;
  transition: all 0.3s;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-outline-secondary:hover {
  background-color: #f8f9fa;
}
</style>