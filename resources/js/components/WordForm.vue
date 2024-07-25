<template>
    <div>
      <form @submit.prevent="generateDocument">
        <div>
          <label for="title">Название документа</label>
          <input type="text" id="title" v-model="title" required>
        </div>
        <div>
          <label for="date">Дата создания документа</label>
          <input type="date" id="date" v-model="date" required>
        </div>
        <button type="submit">Сгенерировать</button>
      </form>
      <div v-if="downloadUrl">
        <a :href="downloadUrl" download="document.docx">Скачать документ</a>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  
  const title = ref('');
  const date = ref('');
  const downloadUrl = ref('');
  
  const generateDocument = async () => {
    try {
      const response = await axios.post('/api/generate', {
        title: title.value,
        date: date.value
      }, {
        responseType: 'blob' 
      });

      const url = window.URL.createObjectURL(new Blob([response.data]));
      downloadUrl.value = url;
      
    } catch (error) {
      console.error('Ошибка при генерации документа:', error);
    }
  };
  </script>
  