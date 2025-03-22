CREATE TABLE public.contacts (
    insee character(5) NOT NULL,
    telephone character(10) NOT NULL,
    id integer NOT NULL
);


ALTER TABLE public.contacts OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16396)
-- Name: contacts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.contacts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.contacts_id_seq OWNER TO postgres;

--
-- TOC entry 4795 (class 0 OID 0)
-- Dependencies: 218
-- Name: contacts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.contacts_id_seq OWNED BY public.contacts.id;


--
-- TOC entry 4641 (class 2604 OID 16397)
-- Name: contacts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contacts ALTER COLUMN id SET DEFAULT nextval('public.contacts_id_seq'::regclass);


--
-- TOC entry 4643 (class 2606 OID 16402)
-- Name: contacts contacts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contacts
    ADD CONSTRAINT contacts_pkey PRIMARY KEY (id);


-- Completed on 2025-03-22 19:50:51

--
-- PostgreSQL database dump complete
--
