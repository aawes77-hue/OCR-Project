document.getElementById('ocrForm').addEventListener('submit', async (event) => {
  event.preventDefault();

  const formData = new FormData();
  formData.append('image', document.getElementById('imageInput').files[0]);

  try {
    const response = await fetch('extract.php', {
      method: 'POST',
      body: formData,
    });

    const result = await response.text();  // Get the PHP response as text
    console.log(result);  // Check if the table is returned

    document.getElementById('result').innerHTML = `
      <h3>Extracted Text:</h3>
      ${result}  <!-- Replace with the extracted table -->
    `;
  } catch (error) {
    console.error('Error:', error);
    document.getElementById('result').innerHTML = '<p>Error extracting text. Please try again.</p>';
  }
});
