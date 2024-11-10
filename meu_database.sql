--
-- PostgreSQL database dump
--

-- Dumped from database version 17.0
-- Dumped by pg_dump version 17.0

-- Started on 2024-11-10 15:45:33

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 220 (class 1259 OID 16400)
-- Name: anuidades; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.anuidades (
    id integer NOT NULL,
    ano integer NOT NULL,
    valor numeric(10,2) NOT NULL,
    associado_id integer NOT NULL,
    pago boolean DEFAULT false
);


ALTER TABLE public.anuidades OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16399)
-- Name: anuidades_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.anuidades_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.anuidades_id_seq OWNER TO postgres;

--
-- TOC entry 4826 (class 0 OID 0)
-- Dependencies: 219
-- Name: anuidades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.anuidades_id_seq OWNED BY public.anuidades.id;


--
-- TOC entry 218 (class 1259 OID 16389)
-- Name: associados; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.associados (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    cpf character(11) NOT NULL,
    data_filiacao date NOT NULL
);


ALTER TABLE public.associados OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16388)
-- Name: associados_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.associados_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.associados_id_seq OWNER TO postgres;

--
-- TOC entry 4827 (class 0 OID 0)
-- Dependencies: 217
-- Name: associados_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.associados_id_seq OWNED BY public.associados.id;


--
-- TOC entry 222 (class 1259 OID 16407)
-- Name: pagamentos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pagamentos (
    id integer NOT NULL,
    associado_id integer NOT NULL,
    anuidade_id integer NOT NULL,
    pago boolean DEFAULT false,
    data_pagamento date,
    ano integer
);


ALTER TABLE public.pagamentos OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16406)
-- Name: pagamentos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pagamentos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pagamentos_id_seq OWNER TO postgres;

--
-- TOC entry 4828 (class 0 OID 0)
-- Dependencies: 221
-- Name: pagamentos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pagamentos_id_seq OWNED BY public.pagamentos.id;


--
-- TOC entry 4652 (class 2604 OID 16403)
-- Name: anuidades id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.anuidades ALTER COLUMN id SET DEFAULT nextval('public.anuidades_id_seq'::regclass);


--
-- TOC entry 4651 (class 2604 OID 16392)
-- Name: associados id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.associados ALTER COLUMN id SET DEFAULT nextval('public.associados_id_seq'::regclass);


--
-- TOC entry 4654 (class 2604 OID 16410)
-- Name: pagamentos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagamentos ALTER COLUMN id SET DEFAULT nextval('public.pagamentos_id_seq'::regclass);


--
-- TOC entry 4818 (class 0 OID 16400)
-- Dependencies: 220
-- Data for Name: anuidades; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.anuidades (id, ano, valor, associado_id, pago) FROM stdin;
\.


--
-- TOC entry 4816 (class 0 OID 16389)
-- Dependencies: 218
-- Data for Name: associados; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.associados (id, nome, email, cpf, data_filiacao) FROM stdin;
\.


--
-- TOC entry 4820 (class 0 OID 16407)
-- Dependencies: 222
-- Data for Name: pagamentos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pagamentos (id, associado_id, anuidade_id, pago, data_pagamento, ano) FROM stdin;
\.


--
-- TOC entry 4829 (class 0 OID 0)
-- Dependencies: 219
-- Name: anuidades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.anuidades_id_seq', 17, true);


--
-- TOC entry 4830 (class 0 OID 0)
-- Dependencies: 217
-- Name: associados_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.associados_id_seq', 10, true);


--
-- TOC entry 4831 (class 0 OID 0)
-- Dependencies: 221
-- Name: pagamentos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pagamentos_id_seq', 1, false);


--
-- TOC entry 4663 (class 2606 OID 16405)
-- Name: anuidades anuidades_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.anuidades
    ADD CONSTRAINT anuidades_pkey PRIMARY KEY (id);


--
-- TOC entry 4657 (class 2606 OID 16398)
-- Name: associados associados_cpf_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.associados
    ADD CONSTRAINT associados_cpf_key UNIQUE (cpf);


--
-- TOC entry 4659 (class 2606 OID 16396)
-- Name: associados associados_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.associados
    ADD CONSTRAINT associados_email_key UNIQUE (email);


--
-- TOC entry 4661 (class 2606 OID 16394)
-- Name: associados associados_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.associados
    ADD CONSTRAINT associados_pkey PRIMARY KEY (id);


--
-- TOC entry 4665 (class 2606 OID 16413)
-- Name: pagamentos pagamentos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagamentos
    ADD CONSTRAINT pagamentos_pkey PRIMARY KEY (id);


--
-- TOC entry 4666 (class 2606 OID 16434)
-- Name: anuidades associado_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.anuidades
    ADD CONSTRAINT associado_id FOREIGN KEY (associado_id) REFERENCES public.associados(id) ON DELETE CASCADE;


--
-- TOC entry 4667 (class 2606 OID 16424)
-- Name: anuidades fk_associado; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.anuidades
    ADD CONSTRAINT fk_associado FOREIGN KEY (associado_id) REFERENCES public.associados(id) ON DELETE CASCADE;


--
-- TOC entry 4668 (class 2606 OID 16419)
-- Name: pagamentos pagamentos_anuidade_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagamentos
    ADD CONSTRAINT pagamentos_anuidade_id_fkey FOREIGN KEY (anuidade_id) REFERENCES public.anuidades(id) ON DELETE CASCADE;


--
-- TOC entry 4669 (class 2606 OID 16414)
-- Name: pagamentos pagamentos_associado_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagamentos
    ADD CONSTRAINT pagamentos_associado_id_fkey FOREIGN KEY (associado_id) REFERENCES public.associados(id) ON DELETE CASCADE;


-- Completed on 2024-11-10 15:45:34

--
-- PostgreSQL database dump complete
--

