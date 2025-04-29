<template>
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3">🚗 Vehículos y Contactos</h1>
      <button @click="irCrear" class="btn btn-success shadow-sm">
        Crear Nuevo
      </button>
    </div>

    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
      </div>
    </div>

    <div v-else>
      <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>Placa</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Año</th>
              <th>Nombre del Contacto</th>
              <th>Documento</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="vehiculo in vehiculos" :key="vehiculo.id">
              <td>{{ vehiculo.plate }}</td>
              <td>{{ vehiculo.brand }}</td>
              <td>{{ vehiculo.model }}</td>
              <td>{{ vehiculo.manufacturing_year }}</td>
              <td>{{ vehiculo.contact?.first_name }} {{ vehiculo.contact?.last_name }}</td>
              <td>{{ vehiculo.contact?.document_number }}</td>
              <td>{{ vehiculo.contact?.email }}</td>
              <td>{{ vehiculo.contact?.phone }}</td>
              <td>
                <div class="btn-group" role="group">
                  <button @click="irEditar(vehiculo.id)" class="btn btn-warning btn-sm">
                    Editar
                  </button>
                  <button @click="eliminarVehiculo(vehiculo.id)" class="btn btn-danger btn-sm">
                    Eliminar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="vehiculos.length === 0" class="text-center my-4 text-muted">
        No hay vehículos registrados todavía.
      </div>

      <!-- Paginación -->
      <nav v-if="pagination.last_page > 1" class="d-flex justify-content-center mt-4">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
            <a @click.prevent="cargarVehiculos(pagination.current_page - 1)" class="page-link" href="#">
              <i class="fas fa-chevron-left"></i>
            </a>
          </li>
          <li v-for="page in paginationLinks" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
            <a @click.prevent="cargarVehiculos(page)" class="page-link" href="#">
              {{ page }}
            </a>
          </li>
          <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
            <a @click.prevent="cargarVehiculos(pagination.current_page + 1)" class="page-link" href="#">
              <i class="fas fa-chevron-right"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      vehiculos: [],
      loading: true,
      pagination: {
        current_page: 1,
        last_page: 1,
      },
    };
  },
  computed: {
    paginationLinks() {
      const current = this.pagination.current_page;
      const last = this.pagination.last_page;
      const delta = 2;
      const range = [];

      for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
        range.push(i);
      }

      if (current - delta > 2) {
        range.unshift('...');
      }
      if (current + delta < last - 1) {
        range.push('...');
      }

      range.unshift(1);
      if (last !== 1) range.push(last);

      return range;
    },
  },
  methods: {
    async cargarVehiculos(page = 1) {
      this.loading = true;
      try {
        const response = await axios.get(`api/list?page=${page}`);
        this.vehiculos = response.data.data;
        this.pagination.current_page = response.data.current_page;
        this.pagination.last_page = response.data.last_page;
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
    irCrear() {
      window.location.href = '/vehicles/create';
    },
    irEditar(id) {
      window.location.href = `/vehicles/${id}/edit`;
    },
    eliminarVehiculo(id) {
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar',
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            await axios.delete(`/vehicles/${id}`);
            Swal.fire('¡Eliminado!', 'El vehículo ha sido eliminado.', 'success');
            this.cargarVehiculos();
          } catch (error) {
            Swal.fire('Error', 'Hubo un problema al eliminar.', 'error');
          }
        }
      });
    },
  },
  mounted() {
    this.cargarVehiculos();
  },
};
</script>

<style scoped>
.table th {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
  border-top: none;
}

.table td {
  vertical-align: middle;
}

.table-responsive {
  margin-top: 20px;
}

.page-item.active .page-link {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.page-link {
  color: #0d6efd;
}

.pagination {
  --bs-pagination-font-size: 0.9rem;
}

.pagination .page-item.disabled .page-link {
  pointer-events: none;
  opacity: 0.5;
}

.pagination i {
  font-size: 1.1rem;
}

.btn-group .btn {
  font-size: 0.85rem;
  padding: 0.5rem 1rem;
}
</style>
