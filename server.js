const express = require('express');
const cors = require('cors');
const { NotDiamond } = require('notdiamond');

const app = express();
const port = 4000;

// Initialize NotDiamond
const notDiamond = new NotDiamond({
  apiKey: `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`, // Load API key from environment
});

app.use(cors());
app.use(express.json());

// AI Assistant Endpoint
app.post('/assistant-response', async (req, res) => {
    console.log('Received query:', req.body.query);
    try {
        const result = await notDiamond.create({
            messages: [{ content: req.body.query, role: 'user' }],
            llmProviders: [
                { provider: 'openai', model: 'gpt-4o-2024-05-13' },
            ],
            tradeoff: 'latency',
        });
        console.log('API Result:', result);
        res.json({ reply: result.content });
    } catch (error) {
        console.error('Error:', error.response?.data || error.message);
        res.status(500).json({ reply: 'Sorry, something went wrong.' });
    }
});


// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
