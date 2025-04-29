<template>
  <div class="container mt-4">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white">
        <h1 class="h3 mb-0">
          <i class="fas fa-edit me-2"></i>Editar Vehículo y Contacto
        </h1>
      </div>
      
      <div class="card-body">
        <form @submit.prevent="actualizarVehiculo">
          <div class="row g-4">
            <!-- Sección Vehículo -->
            <div class="col-lg-6">
              <div class="card h-100">
                <div class="card-header bg-light">
                  <h2 class="h5 mb-0">
                    <i class="fas fa-car me-2"></i>Datos del Vehículo
                  </h2>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label">Placa <span class="text-danger">*</span></label>
                    <input v-model="form.plate" type="text" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Marca <span class="text-danger">*</span></label>
                    <input v-model="form.brand" type="text" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Modelo <span class="text-danger">*</span></label>
                    <input v-model="form.model" type="text" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Año de Fabricación <span class="text-danger">*</span></label>
                    <input v-model="form.manufacturing_year" type="number" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Sección Contacto -->
            <div class="col-lg-6">
              <div class="card h-100">
                <div class="card-header bg-light">
                  <h2 class="h5 mb-0">
                    <i class="fas fa-user me-2"></i>Datos del Contacto
                  </h2>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input v-model="form.first_name" type="text" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Apellido <span class="text-danger">*</span></label>
                    <input v-model="form.last_name" type="text" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Documento <span class="text-danger">*</span></label>
                    <input v-model="form.document_number" type="text" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                    <input v-model="form.email" type="email" class="form-control" required>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                    <input v-model="form.phone" type="text" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Botones de acción -->
          <div class="d-flex justify-content-between mt-4">
            <button @click="regreso" type="button" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Regresar
            </button>
            
            <button type="submit" class="btn btn-primary" :disabled="loading">
              <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
              <i v-else class="fas fa-save me-2"></i>
              {{ loading ? 'Guardando...' : 'Guardar Cambios' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  props: {
    vehiculoId: {
      type: [Number, String],
      required: true,
    },
  },
  data() {
    return {
      form: {
        plate: '',
        brand: '',
        model: '',
        manufacturing_year: '',
        first_name: '',
        last_name: '',
        document_number: '',
        email: '',
        phone: ''
      },
      loading: false,
      errors: {}
    };
  },
  methods: {
    regreso() {
      window.location.href= '/vehicles';
    },
    async cargarVehiculo() {
  try {
    const response = await axios.get(`/api/${this.vehiculoId}/listar`);
    if (response.data && response.data.length > 0) {
      this.form = {
        ...response.data[0],
        vehicle: {
          id: response.data[0].id,
          plate: response.data[0].plate,
          brand: response.data[0].brand,
          model: response.data[0].model,
          manufacturing_year: response.data[0].manufacturing_year
        },
        contact: {
          first_name: response.data[0].first_name,
          last_name: response.data[0].last_name,
          document_number: response.data[0].document_number,
          email: response.data[0].email,
          phone: response.data[0].phone
        }
      };
    } else {
      throw new Error('Vehículo sin contactos registrados');
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: error.response?.data?.error || 'No se pudo cargar el vehículo',
      timer: 2000
    });
    this.$router.push('/vehicles');
  }
},
    async actualizarVehiculo() {
      this.loading = true;
      try {
        const response = await axios.put(`/vehicles/${this.vehiculoId}`, this.form);
        
        Swal.fire({
          icon: 'success',
          title: '¡Guardado!',
          text: 'Los cambios se guardaron correctamente',
          showConfirmButton: false,
          timer: 2000
        }).then(() => {
          this.regreso();
        });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
          Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            html: Object.values(this.errors).flat().join('<br>')
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al guardar los cambios'
          });
        }
      } finally {
        this.loading = false;
      }
    }
  },
  mounted() {
    this.cargarVehiculo();
  }
};
</script>

<style scoped>
.card {
  border-radius: 8px;
  border: none;
}

.card-header {
  border-radius: 8px 8px 0 0 !important;
}

.form-control:focus {
  border-color: #86b7fe;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn {
  padding: 0.5rem 1.5rem;
  font-weight: 500;
  min-width: 150px;
}

.btn-primary {
  background-color: #0d6efd;
  border: none;
}

.btn-primary:hover {
  background-color: #0b5ed7;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-primary:disabled {
  background-color: #6c757d;
  transform: none;
  box-shadow: none;
}

.btn-outline-secondary:hover {
  background-color: #f8f9fa;
}

.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  color: #dc3545;
  font-size: 0.875em;
}
</style>