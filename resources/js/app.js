import mqtt from 'mqtt';

window.connectToAdafruit = (username, activeKey, feedName, onMessage) => {
    const client = mqtt.connect(`wss://io.adafruit.com:443/mqtt`, {
        username: username,
        password: activeKey,
        clientId: 'mqttjs_' + Math.random().toString(16).substr(2, 8),
    });

    client.on('connect', () => {
        const topic = `${username}/feeds/${feedName}`;
        client.subscribe(topic);
    });

    client.on('message', (topic, message) => {
        onMessage(message.toString());
    });

    client.on('error', (err) => {
        client.end();
    });

    return client;
};
