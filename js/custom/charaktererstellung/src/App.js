import React, {Component} from 'react';

import Person from './Components/Views/Person';
import Class from './Components/Views/Class';
import Attributes from './Components/Views/Attributes';
import Advantages from './Components/Views/Advantages';
import Subclass from './Components/Views/Subclass';

import Stepper from '@material-ui/core/Stepper';
import Step from '@material-ui/core/Step';
import StepLabel from '@material-ui/core/StepLabel';
import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';


import './App.css';

const PERSON_SIZES = {
    max: 210,
    min: 130
};

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            steps: [
                'Person',
                'Klasse',
                'Eigenschaften',
                'Vorteile / Nachteile',
                'Unterklasse'
            ],
            activeStep: 0,
            'person': {
                'firstname': '',
                'surname': '',
                'gender': 'female',
                'dateOfBirth': '1995-01-01',
                'eyeColor': '',
                'size': '',
                'sexuality': '',
                'residence': ''
            },
            'class': {
                'id': ''
            },
            'attributes': {
                'element': '',
                'odo': '',
                'circuit': '',
                'luck': ''
            },
            'advantages': [],
            'disadvantages': [],
            'specificClass': {
                'id': ''
            }
        };
        this.getStepContent = this.getStepContent.bind(this);
        this.handleStepChange = this.handleStepChange.bind(this);
        this.handleGenderChange = this.handleGenderChange.bind(this);
        this.handleSexualityChange = this.handleSexualityChange.bind(this);
        this.handleEyecolorChange = this.handleEyecolorChange.bind(this);
        this.handleSizeChange = this.handleSizeChange.bind(this);
        this.handleSizeValidation = this.handleSizeValidation.bind(this);
        this.handleResidenceChange = this.handleResidenceChange.bind(this);
    }

    handleStepChange(nextStep) {
        this.setState({
            ...this.state,
            'activeStep': nextStep
        });
    }

    getStepContent(stepIndex) {
        switch (stepIndex) {
            case 1:
                return <Class {...this.state} />;
            case 2:
                return <Attributes {...this.state} />;
            case 3:
                return <Advantages {...this.state} />;
            case 4:
                return <Subclass {...this.state} />;
            default:
                return <Person {...this.state}
                               handleEyecolorChange={this.handleEyecolorChange}
                               handleGenderChange={this.handleGenderChange}
                               handleSexualityChange={this.handleSexualityChange}
                               handleSizeChange={this.handleSizeChange}
                               handleSizeValidation={this.handleSizeValidation}
                               handleResidenceChange={this.handleResidenceChange}
                />;
        }
    }

    handleGenderChange(event) {
        let person = this.state.person;
        person.gender = event.target.value;
        this.setState({...this.state, 'person': {...person}});
    }

    handleSexualityChange(event) {
        let person = this.state.person;
        person.sexuality = event.target.value;
        this.setState({...this.state, 'person': {...person}});
    }

    handleEyecolorChange(event) {
        let person = this.state.person;
        person.eyeColor = event.target.value;
        this.setState({...this.state, 'person': {...person}});
    }

    handleResidenceChange(district) {
        let person = this.state.person;
        person.residence = district;
        this.setState({...this.state, 'person': {...person}});
    }

    handleSizeChange(event) {
        this.updateSize(event.target.value);
    }
    handleSizeValidation(event) {
        let size = event.target.value;
        if (size < PERSON_SIZES.min) {
            size = PERSON_SIZES.min;
        }
        if (size > PERSON_SIZES.max) {
            size = PERSON_SIZES.max;
        }
        this.updateSize(size);
    }
    updateSize(size) {
        this.setState({...this.state, 'person': {...this.state.person, size: size}});
    }

    render() {
        const {steps, activeStep} = this.state;
        return (
            <div className="App">
                <header className="App-header">
                    <Typography variant="headline">Neuen Charakter erstellen</Typography>
                    <Typography variant="body1">
                        In den folgenden Schritten werdet ihr in die Lage versetzt, einen Charakter für das Spiel zu
                        erschaffen. Zuerst benötigen wir grundlegende Informationen für euren Charakter.
                    </Typography>
                    <Typography variant="body1">
                        Wichtig: Die folgenden Angaben können in bestimmten Situationen das Spiel beeinflussen und sind
                        nicht überflüssig.
                    </Typography>
                    <Typography variant="body1">
                        Auf <a href="/index/intro">dieser Seite (Für Einsteiger)</a> kannst du dir von Kirei eine
                        Einführung in die Welt des Nasuverse ansehen, um das Spiel ein wenig besser zu verstehen.
                    </Typography>
                </header>
                <Stepper activeStep={activeStep} style={{backgroundColor: '#9cdce2'}}>
                    {steps.map((label, index) => {
                        const stepProps = {};
                        if (activeStep > index) {
                            stepProps.onClick = () => this.handleStepChange(index);
                            stepProps.style = {'cursor': 'pointer'};
                        }
                        return (<Step key={index} {...stepProps} >
                            <StepLabel>{label}</StepLabel>
                        </Step>);
                    })}
                </Stepper>
                <div style={{marginBottom: '22px'}}>
                    {this.getStepContent(activeStep)}
                </div>
                <Button
                    variant="raised"
                    color="primary"
                    onClick={() => this.handleStepChange(activeStep + 1)}
                >
                    {activeStep === steps.length - 1 ? 'Finish' : 'Weiter'}
                </Button>
            </div>
        );
    }
}

export default App;
