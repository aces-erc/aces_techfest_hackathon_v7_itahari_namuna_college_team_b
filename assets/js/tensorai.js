// Import TensorFlow.js
import * as tf from '@tensorflow/tfjs';

// Initialize Training Data
const trainingData = [];
const trainingLabels = [];

// Define Categories for Responses
const categories = {
    'name': 'मेरो नाम Gyan Fit हो।',
    'help': 'म तपाईंलाई मद्दत गर्न सक्छु।',
    'greeting': 'नमस्ते! म तपाईंलाई कसरी सहयोग गर्न सक्छु?',
    'fallback': 'माफ गर्नुहोस्, म तपाईंको अनुरोध बुझ्न असमर्थ छु।',
};

// Preprocess Text Data
function preprocessText(text) {
    return text
        .toLowerCase()
        .replace(/[^\w\s]/gi, '')
        .split(' ')
        .map(word => word.trim());
}

// Add Training Data
function addTrainingData(query, label) {
    const processedQuery = preprocessText(query);
    trainingData.push(processedQuery);
    trainingLabels.push(label);
}

// Save the Model and Tokenizer
async function saveModelAndTokenizer(model, tokenizer, filePath) {
    // Save model
    await model.save(`downloads://${filePath}-model`);
    // Save tokenizer
    const tokenizerData = JSON.stringify(tokenizer);
    const blob = new Blob([tokenizerData], { type: 'application/json' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `${filePath}-tokenizer.json`;
    link.click();
}

// Prepare TensorFlow.js Model
async function trainAndSaveModel() {
    // Tokenize data
    const tokenizer = new Set(trainingData.flat());
    const tokenArray = Array.from(tokenizer);
    const encodeText = text =>
        text.map(word => tokenArray.indexOf(word) + 1 || 0);

    // Convert data to tensors
    const encodedData = trainingData.map(encodeText);
    const maxLength = Math.max(...encodedData.map(d => d.length));
    const paddedData = encodedData.map(d =>
        tf.pad1d(tf.tensor1d(d, 'int32'), [0, maxLength - d.length])
    );

    const labelsTensor = tf.tensor1d(trainingLabels, 'int32');

    // Build model
    const model = tf.sequential();
    model.add(tf.layers.embedding({ inputDim: tokenArray.length, outputDim: 50, inputLength: maxLength }));
    model.add(tf.layers.lstm({ units: 50, returnSequences: false }));
    model.add(tf.layers.dense({ units: Object.keys(categories).length, activation: 'softmax' }));

    model.compile({ optimizer: 'adam', loss: 'sparseCategoricalCrossentropy', metrics: ['accuracy'] });

    // Train model
    const xs = tf.stack(paddedData);
    const ys = labelsTensor;
    await model.fit(xs, ys, { epochs: 10 });

    // Save model and tokenizer
    await saveModelAndTokenizer(model, tokenArray, 'gyan-fit');
}

// Add Example Training Data
addTrainingData('तिम्रो नाम के हो?', 0); // 'name'
addTrainingData('मलाई सहयोग चाहिन्छ।', 1); // 'help'
addTrainingData('नमस्ते', 2); // 'greeting'

// Train and Save Model
trainAndSaveModel();
