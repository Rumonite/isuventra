<template>
  <IonPage>
    <!-- Header -->
    <IonHeader translucent>
      <IonToolbar>
        <IonTitle>ISUVENTRA Dashboard</IonTitle>
      </IonToolbar>
    </IonHeader>

    <!-- Main Content -->
    <IonContent :fullscreen="true" class="ion-padding">

      <!-- Metrics Cards -->
      <IonGrid>
        <IonRow>
          <IonCol size="12" size-md="4">
            <IonCard color="primary">
              <IonCardHeader>
                <IonCardTitle>Total Students</IonCardTitle>
              </IonCardHeader>
              <IonCardContent class="text-center text-3xl font-bold">
                {{ stats.students ?? 'N/A' }}
              </IonCardContent>
            </IonCard>
          </IonCol>

          <IonCol size="12" size-md="4">
            <IonCard color="success">
              <IonCardHeader>
                <IonCardTitle>Total Events</IonCardTitle>
              </IonCardHeader>
              <IonCardContent class="text-center text-3xl font-bold">
                {{ stats.events ?? 'N/A' }}
              </IonCardContent>
            </IonCard>
          </IonCol>

          <IonCol size="12" size-md="4">
            <IonCard color="tertiary">
              <IonCardHeader>
                <IonCardTitle>Total Participations</IonCardTitle>
              </IonCardHeader>
              <IonCardContent class="text-center text-3xl font-bold">
                {{ stats.participations ?? 'N/A' }}
              </IonCardContent>
            </IonCard>
          </IonCol>
        </IonRow>
      </IonGrid>

      <!-- Recent Participations -->
      <IonCard>
        <IonCardHeader>
          <IonCardTitle>Recent Participations</IonCardTitle>
        </IonCardHeader>
        <IonCardContent>
          <IonList>
            <IonItem v-for="(p, index) in recentParticipations" :key="index">
              <IonLabel>
                <h2>{{ p.student }}</h2>
                <p>{{ p.event }} - {{ p.time_in }}</p>
              </IonLabel>
            </IonItem>
            <IonItem v-if="recentParticipations.length === 0">
              <IonLabel>No recent participations.</IonLabel>
            </IonItem>
          </IonList>
        </IonCardContent>
      </IonCard>

      <!-- Top Events -->
      <IonCard>
        <IonCardHeader>
          <IonCardTitle>Top Events</IonCardTitle>
        </IonCardHeader>
        <IonCardContent>
          <IonList>
            <IonItem v-for="(event, index) in topEvents" :key="index">
              <IonLabel>
                <h2>{{ event.title }}</h2>
                <p>Participations: {{ event.participations_count }}</p>
              </IonLabel>
            </IonItem>
            <IonItem v-if="topEvents.length === 0">
              <IonLabel>No data.</IonLabel>
            </IonItem>
          </IonList>
        </IonCardContent>
      </IonCard>

      <!-- Top Students -->
      <IonCard>
        <IonCardHeader>
          <IonCardTitle>Top Students</IonCardTitle>
        </IonCardHeader>
        <IonCardContent>
          <IonList>
            <IonItem v-for="(student, index) in topStudents" :key="index">
              <IonLabel>
                <h2>{{ student.name }}</h2>
                <p>Participations: {{ student.participations_count }}</p>
              </IonLabel>
            </IonItem>
            <IonItem v-if="topStudents.length === 0">
              <IonLabel>No data.</IonLabel>
            </IonItem>
          </IonList>
        </IonCardContent>
      </IonCard>

      <!-- Chart -->
      <IonCard>
        <IonCardHeader>
          <IonCardTitle>Event Participation Chart</IonCardTitle>
        </IonCardHeader>
        <IonCardContent>
          <canvas id="eventParticipationChart"></canvas>
        </IonCardContent>
      </IonCard>

      <!-- Manage Students -->
      <IonCard>
        <IonCardHeader>
          <IonCardTitle>Manage Students</IonCardTitle>
        </IonCardHeader>
        <IonCardContent>
          <!-- Add Student Form -->
          <form @submit.prevent="addStudent">
            <IonItem>
              <IonInput v-model="newStudent.student_id" label="Student ID" required />
            </IonItem>
            <IonItem>
              <IonInput v-model="newStudent.name" label="Full Name" required />
            </IonItem>
            <IonItem>
              <IonInput v-model="newStudent.course" label="Course" required />
            </IonItem>
            <IonItem>
              <IonInput v-model="newStudent.year_level" label="Year Level" type="number" required />
            </IonItem>
            <IonItem>
              <IonInput v-model="newStudent.campus" label="Campus" required />
            </IonItem>
            <IonButton expand="block" type="submit" color="primary" class="mt-3">Add Student</IonButton>
          </form>

          <!-- Student List -->
          <IonList class="mt-4">
            <IonItem v-for="(student, index) in studentsList" :key="index" lines="full">
              <IonLabel>{{ student.student_id }} - {{ student.name }}</IonLabel>
              <IonButton color="danger" @click="deleteStudent(student.id)">Delete</IonButton>
            </IonItem>
            <IonItem v-if="studentsList.length === 0">
              <IonLabel>No students found.</IonLabel>
            </IonItem>
          </IonList>
        </IonCardContent>
      </IonCard>
    </IonContent>
  </IonPage>
</template>

<script setup>
import {
  IonPage, IonHeader, IonToolbar, IonTitle, IonContent,
  IonGrid, IonRow, IonCol,
  IonCard, IonCardHeader, IonCardTitle, IonCardContent,
  IonList, IonItem, IonLabel, IonInput, IonButton
} from '@ionic/vue';
import { onMounted, reactive, ref } from 'vue';
import Chart from 'chart.js/auto';

// Fake data (replace with API calls)
const stats = reactive({
  students: 123,
  events: 45,
  participations: 678
});

const recentParticipations = ref([
  { student: 'John Doe', event: 'Hackathon', time_in: '2025-09-23 10:00' }
]);

const topEvents = ref([
  { title: 'Tech Week', participations_count: 200 }
]);

const topStudents = ref([
  { name: 'Jane Doe', participations_count: 15 }
]);

const eventParticipationData = ref([
  { title: 'Event A', participations_count: 50 },
  { title: 'Event B', participations_count: 75 }
]);

// Chart
onMounted(() => {
  const ctx = document.getElementById('eventParticipationChart');
  if (ctx) {
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: eventParticipationData.value.map(e => e.title),
        datasets: [{
          label: 'Participations',
          data: eventParticipationData.value.map(e => e.participations_count),
          backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
      },
      options: { responsive: true, plugins: { legend: { display: false } } }
    });
  }
});

// Manage Students
const studentsList = ref([{ id: 1, student_id: '2025-001', name: 'John Smith' }]);
const newStudent = reactive({ student_id: '', name: '', course: '', year_level: '', campus: '' });

function addStudent() {
  if (newStudent.name) {
    studentsList.value.push({ ...newStudent, id: Date.now() });
    Object.keys(newStudent).forEach(k => newStudent[k] = '');
  }
}

function deleteStudent(id) {
  studentsList.value = studentsList.value.filter(s => s.id !== id);
}
</script>
